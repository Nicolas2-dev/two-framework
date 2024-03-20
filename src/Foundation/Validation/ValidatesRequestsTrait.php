<?php

namespace Two\Foundation\Validation;

use Two\Http\Exception\HttpResponseException;
use Two\Http\JsonResponse;
use Two\Http\Request;
use Two\Validation\Validator;
use Two\Support\Facades\App;
use Two\Support\Facades\Redirect;


trait ValidatesRequestsTrait
{
    /**
     * The default error bag.
     *
     * @var string
     */
    protected $validatesRequestErrorBag;


    /**
     * Validate the given request with the given rules.
     *
     * @param  \Two\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $attributes
     * @return void
     *
     * @throws \Two\Http\Exception\HttpResponseException
     */
    public function validate(Request $request, array $rules, array $messages = array(), array $attributes = array())
    {
        $input = $request->all();

        $validator = $this->getValidationFactory()
            ->make($input, $rules, $messages, $attributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  \Two\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $attributes
     * @return void
     *
     * @throws \Two\Http\Exception\HttpResponseException
     */
    public function validateWithBag($errorBag, Request $request, array $rules, array $messages = array(), array $attributes = array())
    {
        $this->withErrorBag($errorBag, function () use ($request, $rules, $messages, $attributes)
        {
            $this->validate($request, $rules, $messages, $attributes);
        });
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Two\Validation\Validator  $validator
     * @return void
     *
     * @throws \Two\Http\Exception\HttpResponseException
     */
    protected function throwValidationException(Request $request, $validator)
    {
        $response = $this->buildFailedValidationResponse(
            $request, $this->formatValidationErrors($validator)
        );

        throw new HttpResponseException($response);
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Two\Http\Request  $request
     * @param  array  $errors
     * @return \Two\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        $url = $this->getRedirectUrl();

        return Redirect::to($url)
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Two\Validation\Validator  $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return App::make('url')->previous();
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Two\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return App::make('validator');
    }

    /**
     * Execute a Closure within with a given error bag set as the default bag.
     *
     * @param  string  $errorBag
     * @param  callable  $callback
     * @return void
     */
    protected function withErrorBag($errorBag, callable $callback)
    {
        $this->validatesRequestErrorBag = $errorBag;

        call_user_func($callback);

        $this->validatesRequestErrorBag = null;
    }

    /**
     * Get the key to be used for the view error bag.
     *
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }
}
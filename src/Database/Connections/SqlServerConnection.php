<?php

namespace Two\Database\Connections;

use Two\Database\Connection;
use Two\Database\Query\Grammars\SqlServerGrammar as QueryGrammar;
use Two\Database\Query\Processors\SqlServerProcessor as QueryProcessor;
use Two\Database\Schema\Grammars\SqlServerGrammar as SchemaGrammar;

use Doctrine\DBAL\Driver\PDOSqlsrv\Driver as DoctrineDriver;

use Closure;


class SqlServerConnection extends Connection
{

    /**
     * Execute a Closure within a transaction.
     *
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function transaction(Closure $callback)
    {
        if ($this->getDriverName() == 'sqlsrv') {
            return parent::transaction($callback);
        }

        $this->pdo->exec('BEGIN TRAN');

        try {
            $result = $callback($this);

            $this->pdo->exec('COMMIT TRAN');
        }
        catch (\Exception $e) {
            $this->pdo->exec('ROLLBACK TRAN');

           throw $e;
        }
        catch (\Throwable $e) {
            $this->pdo->exec('ROLLBACK TRAN');

            throw $e;
        }

        return $result;
    }

    /**
     * Get the default query grammar instance.
     *
     * @return \Two\Database\Query\Grammars\SqlServerGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar());
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Two\Database\Schema\Grammars\SqlServerGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \Two\Database\Query\Processors\Processor
     */
    protected function getDefaultPostProcessor()
    {
        return new QueryProcessor();
    }

    /**
     * Get the Doctrine DBAL Driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOSqlsrv\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}

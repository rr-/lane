<?php
use Chibi\Sql as Sql;
use Chibi\Database as Database;

class Upgrade3 implements IUpgrade
{
	public static function execute()
	{
		$stmt = new Sql\CreateTableStatement();
		$stmt->setTable('list');
		$stmt->addColumn('id', Sql\CreateTableStatement::TYPE_INTEGER);
		$stmt->addColumn('user_id', Sql\CreateTableStatement::TYPE_INTEGER);
		$stmt->addColumn('priority', Sql\CreateTableStatement::TYPE_INTEGER);
		$stmt->addColumn('name', Sql\CreateTableStatement::TYPE_VARCHAR, 20);
		$stmt->addColumn('url_name', Sql\CreateTableStatement::TYPE_VARCHAR, 32);
		$stmt->addColumn('visible', Sql\CreateTableStatement::TYPE_INTEGER, 1);
		$stmt->addColumn('last_update', Sql\CreateTableStatement::TYPE_INTEGER);
		$stmt->addColumn('content', Sql\CreateTableStatement::TYPE_BLOB);
		$stmt->setPrimaryKey('id');
		$stmt->addCheckContraint(new Sql\NegationFunctor(new Sql\IsFunctor('name', new Sql\NullFunctor())));
		$stmt->addCheckContraint(new Sql\NegationFunctor(new Sql\IsFunctor('user_id', new Sql\NullFunctor())));
		$stmt->addCheckContraint(new Sql\NegationFunctor(new Sql\IsFunctor('url_name', new Sql\NullFunctor())));
		Database::exec($stmt);
	}
}

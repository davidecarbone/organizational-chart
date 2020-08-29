<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class NodeTree extends AbstractMigration
{
	public function up()
	{
		$nodeTree = $this->table('node_tree', ['id' => false, 'primary_key' => ['idNode']]);
		$nodeTree
			->addColumn('idNode', 'integer', ['null' => false])
			->addColumn('level', 'integer', ['null' => false])
			->addColumn('iLeft', 'integer', ['null' => false])
			->addColumn('iRight', 'integer', ['null' => false]);

		$nodeTree->addIndex('idNode', ['unique' => true, 'name' => 'index_idNode']);
		$nodeTree->addIndex('level', ['unique' => false, 'name' => 'index_level']);
		$nodeTree->addIndex('iLeft', ['unique' => false, 'name' => 'index_iLeft']);
		$nodeTree->addIndex('iRight', ['unique' => false, 'name' => 'index_iRight']);

		$nodeTree->create();

		$rows = [
			[
				'id'    => 2,
				'name'  => 'Stopped'
			],
			[
				'id'    => 3,
				'name'  => 'Queued'
			]
		];

		$nodeTree->insert([
			['idNode' => 1, 'level' => 2, 'iLeft' => 2, 'iRight' => 3],
			['idNode' => 2, 'level' => 2, 'iLeft' => 4, 'iRight' => 5],
			['idNode' => 3, 'level' => 2, 'iLeft' => 6, 'iRight' => 7],
			['idNode' => 4, 'level' => 2, 'iLeft' => 8, 'iRight' => 9],
			['idNode' => 5, 'level' => 1, 'iLeft' => 1, 'iRight' => 24],
			['idNode' => 6, 'level' => 2, 'iLeft' => 10, 'iRight' => 11],
			['idNode' => 7, 'level' => 2, 'iLeft' => 12, 'iRight' => 19],
			['idNode' => 8, 'level' => 3, 'iLeft' => 15, 'iRight' => 16],
			['idNode' => 9, 'level' => 3, 'iLeft' => 17, 'iRight' => 18],
			['idNode' => 10, 'level' => 2, 'iLeft' => 20, 'iRight' => 21],
			['idNode' => 11, 'level' => 3, 'iLeft' => 13, 'iRight' => 14],
			['idNode' => 12, 'level' => 2, 'iLeft' => 22, 'iRight' => 23]
		])->save();
	}

	public function down()
	{
		$this->table('node_tree')->drop()->save();
	}
}

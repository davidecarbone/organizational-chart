<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NodeTreeNames extends AbstractMigration
{
	public function up()
	{
		$nodeTreeNames = $this->table('node_tree_names');
		$nodeTreeNames
			->addColumn('idNode', 'integer', ['null' => false])
			->addForeignKey('idNode', 'node_tree', 'idNode', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

		$nodeTreeNames
			->addColumn('language', 'enum', ['null' => false, 'values' => ['english', 'italian']])
			->addColumn('nodeName', 'string', ['null' => false]);

		$nodeTreeNames->addIndex('idNode', ['unique' => false, 'name' => 'index_idNode']);

		$nodeTreeNames->create();

		$nodeTreeNames->insert([
			['idNode' => 1, 'language' => 'english', 'nodeName' => 'Marketing'],
			['idNode' => 1, 'language' => 'italian', 'nodeName' => 'Marketing'],
			['idNode' => 2, 'language' => 'english', 'nodeName' => 'Helpdesk'],
			['idNode' => 2, 'language' => 'italian', 'nodeName' => 'Supporto tecnico'],
			['idNode' => 3, 'language' => 'english', 'nodeName' => 'Managers'],
			['idNode' => 3, 'language' => 'italian', 'nodeName' => 'Managers'],
			['idNode' => 4, 'language' => 'english', 'nodeName' => 'Customer account'],
			['idNode' => 4, 'language' => 'italian', 'nodeName' => 'Assistenza cliente'],
			['idNode' => 5, 'language' => 'english', 'nodeName' => 'Docebo'],
			['idNode' => 5, 'language' => 'italian', 'nodeName' => 'Docebo'],
			['idNode' => 6, 'language' => 'english', 'nodeName' => 'Accounting'],
			['idNode' => 6, 'language' => 'italian', 'nodeName' => 'Amministrazione'],
			['idNode' => 7, 'language' => 'english', 'nodeName' => 'Sales'],
			['idNode' => 7, 'language' => 'italian', 'nodeName' => 'Supporto vendite'],
			['idNode' => 8, 'language' => 'english', 'nodeName' => 'Italy'],
			['idNode' => 8, 'language' => 'italian', 'nodeName' => 'Italia'],
			['idNode' => 9, 'language' => 'english', 'nodeName' => 'Europe'],
			['idNode' => 9, 'language' => 'italian', 'nodeName' => 'Europa'],
			['idNode' => 10, 'language' => 'english', 'nodeName' => 'Developers'],
			['idNode' => 10, 'language' => 'italian', 'nodeName' => 'Sviluppatori'],
			['idNode' => 11, 'language' => 'english', 'nodeName' => 'North America'],
			['idNode' => 11, 'language' => 'italian', 'nodeName' => 'Nord America'],
			['idNode' => 12, 'language' => 'english', 'nodeName' => 'Quality Assurance'],
			['idNode' => 12, 'language' => 'italian', 'nodeName' => 'Controllo Qualità']
		])->save();
	}

	public function down()
	{
		$this->table('node_tree_names')->drop()->save();
	}
}

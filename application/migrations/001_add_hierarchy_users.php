<?php
class Migration_add_hierarchy_users extends CI_Migration
{
	public function up()
	{
		$fields = array(
			'jerarquia_user' => array(
				'type' => 'INT',
				'constraint' => 100,
				'after' => 'forma_pago'
			)
		);
		$this->dbforge->add_column('usuarios', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('usuarios', 'jerarquia_user');
	}
}


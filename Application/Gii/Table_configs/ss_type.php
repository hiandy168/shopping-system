<?php
return array(
	'tableName' => 'ss_type',    // ����
	'tableCnName' => '',  // ���������
	'moduleName' => 'Admin',  // �������ɵ���ģ��
	'withPrivilege' => FALSE,  // �Ƿ�������ӦȨ�޵�����
	'topPriName' => '',        // ����Ȩ�޵�����
	'digui' => 0,             // �Ƿ����޼����ݹ飩
	'diguiName' => '',        // �ݹ�ʱ������ʾ���ֶε����֣���cat_name���������ƣ�
	'pk' => 'id',    // ���������ֶ�����
	/********************* Ҫ���ɵ�ģ���ļ��еĴ��� ******************************/
	// ���ʱ������յı��е��ֶ�
	'insertFields' => "array('type_name')",
	// �޸�ʱ������յı��е��ֶ�
	'updateFields' => "array('id','type_name')",
	'validate' => "
		array('type_name', 'require', '�������Ʋ���Ϊ�գ�', 1, 'regex', 3),
		array('type_name', '1,30', '�������Ƶ�ֵ����ܳ��� 30 ���ַ���', 1, 'length', 3),
		array('type_name', '', '���������Ѿ����ڣ�', 1, 'unique', 3),
	",
	/********************** ����ÿ���ֶ���Ϣ������ ****************************/
	'fields' => array(
		'type_name' => array(
			'text' => '��������',
			'type' => 'text',
			'default' => '',
		),
	),
	/**************** �����ֶε����� **********************/
	'search' => array(),
);
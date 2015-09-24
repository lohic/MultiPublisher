<?php


$structure = json_decode('[
	{
        "post_parent": 0,
        "ID": 51,
        "post_title": "MAIN Essai Poirier",
        "child": []
    },
    {
        "ID": "66",
        "post_title": "Child of test Ruine",
        "post_name": "child-of-test-ruine",
        "guid": "http://localhost:8888/Site_CDF/?post_type=publication&#038;p=66",
        "post_parent": "57",
        "mp_main_parent_id_key": "51",
        "menu_order": "0",
        "child": []
    },
    {
        "ID": "54",
        "post_title": "Édito",
        "post_name": "edito",
        "guid": "http://localhost:8888/Site_CDF/?post_type=publication&#038;p=54",
        "post_parent": "51",
        "mp_main_parent_id_key": "51",
        "menu_order": "1",
        "child": []
    },
    {
        "ID": "65",
        "post_title": "Images",
        "post_name": "65-2",
        "guid": "http://localhost:8888/Site_CDF/?post_type=publication&#038;p=65",
        "post_parent": "51",
        "mp_main_parent_id_key": "51",
        "menu_order": "2",
        "child": []
    },
    {
        "ID": "57",
        "post_title": "RUINES etc.",
        "post_name": "ruines-etc",
        "guid": "http://localhost:8888/Site_CDF/?post_type=publication&#038;p=57",
        "post_parent": "51",
        "mp_main_parent_id_key": "51",
        "menu_order": "3",
        "child": []
    },
    {
        "ID": "64",
        "post_title": "Images bis",
        "post_name": "images-bis",
        "guid": "http://localhost:8888/Site_CDF/?post_type=publication&#038;p=64",
        "post_parent": "51",
        "mp_main_parent_id_key": "51",
        "menu_order": "4",
        "child": []
    }
]');


//var_dump($structure);

$refs = array();
$list = array();

foreach($structure as $data) {
    $thisref =& $refs[ $data->ID ];
 
    $thisref['account_id'] = $data->ID;
    $thisref['AccountName'] = $data->post_title;
    $thisref['parent_id'] = $data->post_parent;
    //$thisref['AccountType'] = $data['AccountType'];
    //$thisref['AccountNumber'] = $data['AccountNumber'];
 
    if ($data->post_parent == 0) {
        $list[  ] =& $thisref;
    } else {
        $refs[ $data->post_parent ]['childs'][] =& $thisref;
    }
}

$mylist["rows"] = $list; 

echo json_encode($mylist);

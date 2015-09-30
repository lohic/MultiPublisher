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

    $thisref['ID'] 			= $data->ID;
    $thisref['post_title'] 	= $data->post_title;
    $thisref['post_parent'] = $data->post_parent;
 
    if ($data->post_parent == 0) {
        $list[] =& $thisref;
    } else {
        $refs[ $data->post_parent ]['childs'][] =& $thisref;
    }
}


//echo json_encode($list);




function object_to_array($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = object_to_array($val);
        }
    }
    else $new = $obj;
    return $new;       
}

echo json_encode(object_to_array($list));


function analyse_structure($structure_array_json){
	foreach($structure_array_json as $item){

		echo $item['ID']." ".$item['post_title']."<br>\n";

		if( isset($item['childs']) ){
			analyse_structure($item['childs']);
		}
	}
}

//analyse_structure($list);


<?php
// Society — family members module
return [
    'base_tables' => ['Unit' => 'units', 'Resident' => 'residents'],
    'nav' => [
        ['Family Members', 'members.index', 'users'],
    ],
    'modules' => [
        'members' => [
            'model' => 'FamilyMember', 'table' => 'family_members', 'title' => 'Family Member', 'icon' => 'users',
            'columns' => [['unit_id','fkreq:Unit'],['resident_id','fkreq:Resident'],['name','string'],['relation','stringNullable'],['phone','stringNullable'],['occupation','stringNullable'],['status','default:Active']],
            'fillable' => ['unit_id','resident_id','name','relation','phone','occupation','status'],
            'validation' => ['unit_id'=>'required|exists:units,id','resident_id'=>'required|exists:residents,id','name'=>'required|string|max:255','relation'=>'nullable|string|max:60','phone'=>'nullable|string|max:20','occupation'=>'nullable|string|max:120','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['unit_id','Unit','select','@Unit:flat_no',true], ['resident_id','Head / Resident','select','@Resident:name',true],
                ['name','Member Name','text',null,true], ['relation','Relation','select',['Spouse','Child','Parent','Sibling','Other']],
                ['phone','Phone','tel'], ['occupation','Occupation','text'], ['status','Status','select',['Active','Inactive']],
            ],
            'with' => ['unit','resident'],
            'rels' => ['unit' => 'belongsTo:Unit', 'resident' => 'belongsTo:Resident'],
            'cols' => [
                'Unit' => '{{ $r->unit->flat_no }}', 'Head' => '{{ $r->resident->name ?? "—" }}',
                'Member' => '<strong>{{ $r->name }}</strong>', 'Relation' => '{{ $r->relation }}',
                'Phone' => '{{ $r->phone }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'family_members' => [
            ['unit_id' => 1, 'resident_id' => 1, 'name' => 'Meena Shah', 'relation' => 'Spouse', 'occupation' => 'Teacher'],
            ['unit_id' => 1, 'resident_id' => 1, 'name' => 'Aryan Shah', 'relation' => 'Child'],
        ],
    ],
];

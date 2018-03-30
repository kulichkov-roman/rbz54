<?php

$arTemplateParameters = array(
    'CHECKBOX' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'CHECKBOX',
        'NAME' => 'CB',
        'DEFAULT' => 'Y',
        'REFRESH' => 'Y'
    )
);

if ($arCurrentValues['CHECKBOX'] == 'Y')
    $arTemplateParameters['CHECKBOX2'] = array(
        'PARENT' => 'BASE',
        'TYPE' => 'CHECKBOX',
        'NAME' => 'CB2',
        'DEFAULT' => 'Y',
        'MULTIPLE' => 'Y'
    );

$arTemplateParameters['STRING'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => 'STR',
    'DEFAULT' => [
        'test',
        'is',
        'good'
    ],
    'MULTIPLE' => 'Y',
    'REFRESH' => 'Y'
);

$arTemplateParameters['LIST'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'LIST',
    'NAME' => 'LST',
    'VALUES' => [
        'TEST' => 'GOOD',
        'NO' => 'YES'
    ],
    //'MULTIPLE' => 'Y',
    'REFRESH' => 'Y',
    'ADDITIONAL_VALUES' => 'Y'
);

$arTemplateParameters['COLOR'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'COLORPICKER',
    'NAME' => 'CL',
    'REFRESH' => 'Y'
);

$arTemplateParameters['CUSTOM'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'CUSTOM',
    'NAME' => 'CUSTOM',
    'JS_FILE' => '/s2/custom.js',
    'JS_DATA' => 'test||test2||test3',
    'JS_EVENT' => 'TestCustomProperty'
);
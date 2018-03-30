<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php
use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Currency;

if (!Loader::includeModule('iblock'))
    return;
if (!CModule::IncludeModule('form'))
    return;

$rsForms = CForm::GetList($by = 'SORT', $order = 'ASC', array(
    'ACTIVE' => 'Y'
), ($filtered = false));
$arForms = array();

while ($arForm = $rsForms->GetNext())
    $arForms[$arForm['ID']] = '['.$arForm['ID'].'] '.$arForm['NAME'];
/**
 * @var array $arCurrentValues
 */

$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
$arProperty_F = array();
if ($iblockExists) {
    $propertyIterator = Iblock\PropertyTable::getList(array(
        'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
        'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
        'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
    ));
    while ($property = $propertyIterator->fetch()) {
        $propertyCode = (string)$property['CODE'];
        if ($propertyCode == '')
            $propertyCode = $property['ID'];
        $propertyName = '['.$propertyCode.'] '.$property['NAME'];

        if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE) {
            $arProperty[$propertyCode] = $propertyName;

            if ($property['MULTIPLE'] == 'Y')
                $arProperty_X[$propertyCode] = $propertyName;
            elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
                $arProperty_X[$propertyCode] = $propertyName;
            elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
                $arProperty_X[$propertyCode] = $propertyName;
        }
        else
        {
            //if ($property['MULTIPLE'] == 'N')
                $arProperty_F[$propertyCode] = $propertyName;
        }

        if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
            $arProperty_N[$propertyCode] = $propertyName;
    }
    unset($propertyCode, $propertyName, $property, $propertyIterator);
}

$site = ($_REQUEST['site'] <> ''? $_REQUEST['site'] : ($_REQUEST['src_site'] <> ''? $_REQUEST['src_site'] : false));
$arMenu = GetMenuTypes($site);

$arTemplateParameters = array();
$arTemplateParameters['MENU_ROOT_TYPE'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('C_SERVICES_PARAMETERS_MENU_ROOT_TYPE'),
    'TYPE' => 'LIST',
    'DEFAULT'=>'left',
    'VALUES' => $arMenu,
    'ADDITIONAL_VALUES'	=> 'Y',
    'COLS' => 45
);
$arTemplateParameters['MENU_MAX_LEVEL'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('C_SERVICES_PARAMETERS_MENU_MAX_LEVEL'),
    'TYPE' => 'LIST',
    'DEFAULT'=>'1',
    'VALUES' => array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
    ),
    'ADDITIONAL_VALUES'	=> 'N',
);
$arTemplateParameters['MENU_CHILD_TYPE'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('C_SERVICES_PARAMETERS_MENU_CHILD_TYPE'),
    'TYPE' => 'LIST',
    'DEFAULT' => 'left',
    'VALUES' => $arMenu,
    'ADDITIONAL_VALUES'	=> 'Y',
    'COLS' => 45
);

foreach (['SECTIONS', 'ELEMENTS'] as $sItem) {
    $arTemplateParameters[$sItem.'_LIST_VIEW'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('C_SERVICES_PARAMETERS_'.$sItem.'_LIST_VIEW'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'settings' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_SETTINGS'),
            'list' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_LIST'),
            'blocks' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_BLOCKS'),
            'tile' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_TILE'),
            'tile.2' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_TILE_2'),
            'extend' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_EXTEND'),
            'blocks.links' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_BLOCKS_LINKS')
        ),
        'REFRESH' => 'Y'
    );

    $sValue = $arCurrentValues[$sItem.'_LIST_VIEW'];

    if ($sValue == 'blocks.2') {
        $arTemplateParameters[$sItem.'_LIST_VIEW_IMAGES'] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES'),
            'VALUES' => array(
                'CIRCLE' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_CIRCLE'),
                'SQUARE' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_SQUARE'),
            )
        );
    }

    if ($sValue == 'blocks') {
        $arTemplateParameters[$sItem.'_LIST_VIEW_DISPLAY_DESCRIPTION'] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'CHECKBOX',
            'NAME' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_DISPLAY_DESCRIPTION')
        );

        $arTemplateParameters[$sItem.'_LIST_VIEW_IMAGES'] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES'),
            'VALUES' => array(
                'CIRCLE' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_CIRCLE'),
                'SQUARE_SMALL' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_SQUARE_SMALL'),
                'SQUARE_BIG' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_SQUARE_BIG')
            )
        );
    }

    if ($sValue == 'tile') {
        $arValues = array(
            2 => 2,
            3 => 3
        );

        if ($sItem == 'SECTIONS')
            $arValues = array(
                3 => 3,
                4 => 4
            );

        $arTemplateParameters[$sItem.'_LIST_VIEW_LINE_COUNT'] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_LINE_COUNT'),
            'VALUES' => $arValues
        );
    }

    if ($sValue == 'extend') {
        $arTemplateParameters[$sItem.'_LIST_VIEW_IMAGES'] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES'),
            'VALUES' => array(
                'CIRCLE' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_CIRCLE'),
                'SQUARE' => GetMessage('C_SERVICES_PARAMETERS_LIST_VIEW_IMAGES_SQUARE')
            )
        );
    }
}
$arTemplateParameters["TYPE_BANNER"] = array(
    'PARENT' => 'VISUAL',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETERS_ELEMENT_SERVICE_TYPE_BANNER'),
    'VALUES' => array (
        'settings' => GetMessage('C_SERVICES_PARAMETERS_ELEMENT_SERVICE_TYPE_BANNER_SETTINGS'),
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4
    )
);
$arTemplateParameters["TYPE_BANNER_WIDE"] = array(
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'NAME' => GetMessage('C_SERVICES_PARAMETERS_ELEMENT_SERVICE_TYPE_BANNER_WIDE')
);
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);
$arTemplateParameters["NAME_PROP_PROJECTS"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_PROJECTS'),
    'DEFAULT_VALUE' => "PROJECTS",
    "VALUES" => $arProperty,
);
$arTemplateParameters["NAME_PROP_VIDEO"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_VIDEO'),
    'DEFAULT_VALUE' => "VIDEO",
    "VALUES" => $arProperty,
    'REFRESH' => 'Y'
);
if(!empty($arCurrentValues['NAME_PROP_VIDEO'])) {
    $arTemplateParameters["NAME_PROP_URL_VIDEO"] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_URL_VIDEO'),
        'DEFAULT_VALUE' => "SYSTEM_URL_VIDEO",
        "VALUES" => $arProperty
    );
}
$arTemplateParameters["NAME_PROP_PRICE"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_PRICE'),
    'DEFAULT_VALUE' => "GALLERY",
    "VALUES" => $arProperty,
);

$arTemplateParameters["NAME_PROP_GALLERY"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_PHOTOGALLERY'),
    'DEFAULT_VALUE' => "GALLERY",
    "VALUES" => $arProperty_F,
);
$arTemplateParameters["NAME_PROP_REVIEWS"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_REVIEWS'),
    'DEFAULT_VALUE' => "REVIEWS",
    "VALUES" => $arProperty,
    "REFRESH" => "Y"
);
if (!empty($arCurrentValues['NAME_PROP_REVIEWS'])) {
    $arTemplateParameters["NAME_PROP_AUTOR_REVIEW"] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_AUTOR_REVIEW'),
        'DEFAULT_VALUE' => "",
    );
    $arTemplateParameters["NAME_PROP_COMPANY_REVIEW"] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'STRING',
        'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_COMPANY_REVIEW'),
        'DEFAULT_VALUE' => "",
    );
}
$arTemplateParameters["NAME_PROP_SERVICES"] = array(
    'PARENT' => 'DATA_SOURCE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_PROP_SERVICES'),
    'DEFAULT_VALUE' => "SERVICES",
    "VALUES" => $arProperty,
);

$arTemplateParameters["FEEDBACK"] = array(
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_FEEDBACK'),
    'REFRESH' => 'Y'
);
if ($arCurrentValues['FEEDBACK'] == "Y") {
    $arTemplateParameters["FEEDBACK_FORM_ID"] = array(
        'PARENT' => 'VISUAL',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_FEEDBACK_FORM_ID'),
        'DEFAULT_VALUE' => "",
        "VALUES" => $arForms,
    );
}
$arTemplateParameters["SERVICES"] = array(
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_BUY_SERVICE'),
    'REFRESH' => 'Y'
);
if ($arCurrentValues['SERVICES'] == "Y") {
    $arTemplateParameters["SERVICES_FORM_ID"] = array(
        'PARENT' => 'VISUAL',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_SERVICES_PARAMETER_ELEMENT_NAME_SERVICE_FORM_ID'),
        'DEFAULT_VALUE' => "SERVICES",
        "VALUES" => $arForms,
        'REFRESH' => 'Y'
    );
    if(!empty($arCurrentValues["SERVICES_FORM_ID"])) {
        $arFormFields = array();
        $rsFormFields = CFormField::GetList(
            $arCurrentValues["SERVICES_FORM_ID"],
            'N',
            $by = null,
            $asc = null,
            array(
                'ACTIVE' => 'Y'
            ),
            ($filtered = false)
        );

        while ($arFormField = $rsFormFields->GetNext()) {

            $rsFormAnswers = CFormAnswer::GetList(
                $arFormField['ID'],
                $sort = '',
                $order = '',
                array(),
                $filtered = false
            );

            while ($arFormAnswer = $rsFormAnswers->GetNext()) {
                $sType = $arFormAnswer['FIELD_TYPE'];

                if (empty($sType))
                    continue;

                $sId = 'form_'.$sType.'_'.$arFormAnswer['ID'];
                $arFormFields[$sId] = '['.$arFormAnswer['ID'].'] '.$arFormField['TITLE'];
            }
        }

        $arTemplateParameters["PROPERTY_FORM_ORDER_SERVICE"] = array(
            'PARENT' => 'VISUAL',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('PROPERTY_FORM_ORDER_SERVICE'),
            'DEFAULT_VALUE' => "SERVICES",
            "VALUES" => $arFormFields,
            'REFRESH' => 'Y'
        );
    }
}
$arTemplateParameters['LAZY_LOAD'] = array(
    'PARENT' => 'PAGER_SETTINGS',
    'NAME' => GetMessage('CP_BC_TPL_LAZY_LOAD'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y',
    'DEFAULT' => 'N'
);

if (isset($arCurrentValues['LAZY_LOAD']) && $arCurrentValues['LAZY_LOAD'] === 'Y')
{
    $arTemplateParameters['MESS_BTN_LAZY_LOAD'] = array(
        'PARENT' => 'PAGER_SETTINGS',
        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD'),
        'TYPE' => 'STRING',
        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD_DEFAULT')
    );
}
$arTemplateParameters['SHOW_HEADER_SUBMENU'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_SERVICES_PARAMETER_SHOW_HEADER_SUBMENU'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

$arTemplateParameters['MENU_DISPLAY_IN_ROOT'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_ROOT'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_FROM_SETTINGS'),
        'Y' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_YES'),
        'N' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_NO'),
    ),
    'DEFAULT' => 'N'
);

$arTemplateParameters['MENU_DISPLAY_IN_SECTION'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_SECTION'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_FROM_SETTINGS'),
        'Y' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_YES'),
        'N' => GetMessage('C_SERVICES_MENU_DISPLAY_IN_NO'),
    ),
    'DEFAULT' => 'Y'
);

?>
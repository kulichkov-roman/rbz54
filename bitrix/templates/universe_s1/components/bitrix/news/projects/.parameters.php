<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arCurrentValues
 */

if (!CModule::IncludeModule('iblock'))
    return;

if (!CModule::IncludeModule('form'))
    return;

$iIBlockId = $arCurrentValues['IBLOCK_ID'];
$iIBlockIdReviews = $arCurrentValues['IBLOCK_ID_REVIEWS'];

$arIBlocksTypes = array(
    '' => ''
);

$arIBlocksTypes = array_merge(
    $arIBlocksTypes,
    CIBlockParameters::GetIBlockTypes()
);

$arIBlocks = array();
$arIBlocksFilter = array();
$arIBlocksFilter['ACTIVE'] = 'Y';

$rsIBlocks = CIBlock::GetList(array('SORT' => 'ASC'), $arIBlocksFilter);

while ($arIBlock = $rsIBlocks->Fetch())
    $arIBlocks[$arIBlock['ID']] = $arIBlock;

$getIBlocksByType = function ($sType = null) use ($arIBlocks) {
    $arResult = array();

    foreach ($arIBlocks as $arIBlock) {
        $sName = '['.$arIBlock['ID'].'] '.$arIBlock['NAME'];

        if ($arIBlock['IBLOCK_TYPE_ID'] == $sType || $sType == null)
            $arResult[$arIBlock['ID']] = $sName;
    }

    return $arResult;
};

$rsForms = CForm::GetList($by = 'SORT', $order = 'ASC', array(
    'ACTIVE' => 'Y'
), $filtered = false);
$arForms = array();

while ($arForm = $rsForms->GetNext())
    $arForms[$arForm['ID']] = '['.$arForm['ID'].'] '.$arForm['NAME'];

$arTemplateParameters = array(
    'DISPLAY_LIST_TAB_ALL' => array(
        'PARENT' => 'LIST_SETTINGS',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_DISPLAY_TAB_ALL')
    ),
    'IBLOCK_TYPE_SERVICES' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_IBLOCK_TYPE_SERVICES'),
        'VALUES' => $arIBlocksTypes,
        'REFRESH' => 'Y'
    ),
    'IBLOCK_ID_SERVICES' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_IBLOCK_ID_SERVICES'),
        'VALUES' => $getIBlocksByType($arCurrentValues['IBLOCK_TYPE_SERVICES']),
        'ADDITIONAL_VALUES' => 'Y'
    ),
    'ALLOW_LINK_SERVICES' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_ALLOW_LINK_SERVICES')
    ),
    'DETAIL_URL_SERVICES' => CIBlockParameters::GetPathTemplateParam(
        'DETAIL',
        'DETAIL_URL',
        GetMessage('N_PROJECTS_PARAMETERS_DETAIL_URL_SERVICES'),
        '',
        'URL_TEMPLATES'
    ),
    'IBLOCK_TYPE_REVIEWS' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_IBLOCK_TYPE_REVIEWS'),
        'VALUES' => $arIBlocksTypes,
        'REFRESH' => 'Y'
    ),
    'IBLOCK_ID_REVIEWS' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_IBLOCK_ID_REVIEWS'),
        'VALUES' => $getIBlocksByType($arCurrentValues['IBLOCK_TYPE_REVIEWS']),
        'ADDITIONAL_VALUES' => 'Y'
    ),
    'ALLOW_LINK_REVIEWS' => array(
        'PARENT' => 'BASE',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_ALLOW_LINK_REVIEWS')
    ),
    'PAGE_URL_REVIEWS' => array(
        'PARENT' => 'URL_TEMPLATES',
        'TYPE' => 'STRING',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PAGE_URL_REVIEWS')
    ),
    'DETAIL_URL_REVIEWS' => CIBlockParameters::GetPathTemplateParam(
        'DETAIL',
        'DETAIL_URL',
        GetMessage('N_PROJECTS_PARAMETERS_DETAIL_URL_REVIEWS'),
        '',
        'URL_TEMPLATES'
    ),
    'DISPLAY_FORM_ORDER' => array(
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_DISPLAY_FORM_ORDER'),
        'REFRESH' => 'Y'
    ),
    'DISPLAY_FORM_ASK' => array(
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_DISPLAY_FORM_ASK'),
        'REFRESH' => 'Y'
    )
);

if ($arCurrentValues['DISPLAY_FORM_ORDER'] == 'Y') {
    $arTemplateParameters['FORM_ORDER'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_FORM_ORDER'),
        'VALUES' => $arForms,
        'REFRESH' => 'Y'
    );

    if (!empty($arCurrentValues['FORM_ORDER'])) {
        $arFormFields = array();
        $rsFormFields = CFormField::GetList(
            $arCurrentValues['FORM_ORDER'],
            'N',
            $by = null,
            $asc = null,
            array(
                'ACTIVE' => 'Y'
            ),
            $filtered = false
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

        $arTemplateParameters['PROPERTY_FORM_ORDER_PROJECT'] = array(
            'PARENT' => 'DATA_SOURCE',
            'TYPE' => 'LIST',
            'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_FORM_ORDER_PROJECT'),
            'VALUES' => $arFormFields,
            'ADDITIONAL_VALUES' => 'Y'
        );
    }
}

if ($arCurrentValues['DISPLAY_FORM_ASK'] == 'Y') {
    $arTemplateParameters['FORM_ASK'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_FORM_ASK'),
        'VALUES' => $arForms
    );
}

if (!empty($iIBlockId)) {
    $arProperties = array();
    $arPropertiesFiles = array();
    $arPropertiesFile = array();
    $arPropertiesString = array();
    $arPropertiesLink = array();
    $arPropertiesForDescription = array();
    $rsProperties = CIBlockProperty::GetList(array('SORT' => 'ASC'), array(
        'IBLOCK_ID' => $iIBlockId,
        'ACTIVE' => 'Y'
    ));

    while ($arProperty = $rsProperties->GetNext()) {
        $sCode = $arProperty['CODE'];

        if (empty($sCode))
            continue;

        $sName = '['.$arProperty['CODE'].'] '.$arProperty['NAME'];

        if ($arProperty['MULTIPLE'] != 'Y') {
            if (($arProperty['PROPERTY_TYPE'] == 'S' && $arProperty['USER_TYPE'] != 'HTML') || $arProperty['PROPERTY_TYPE'] == 'L')
                $arPropertiesForDescription[$sCode] = $sName;

            if ($arProperty['PROPERTY_TYPE'] == 'S')
                $arPropertiesString[$sCode] = $sName;

            if ($arProperty['PROPERTY_TYPE'] == 'F')
                $arPropertiesFile[$sCode] = $sName;
        } else {
            if ($arProperty['PROPERTY_TYPE'] == 'F')
                $arPropertiesFiles[$sCode] = $sName;
        }

        if ($arProperty['PROPERTY_TYPE'] == 'E')
            $arPropertiesLink[$sCode] = $sName;

        $arProperties[$arProperty['CODE']] = $arProperty;
    }

    $arTemplateParameters['DESCRIPTION_DETAIL_PROPERTIES'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_DESCRIPTION_PROPERTIES'),
        'VALUES' => $arPropertiesForDescription
    );

    $arTemplateParameters['PROPERTY_GALLERY'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_GALLERY'),
        'VALUES' => $arPropertiesFiles
    );

    $arTemplateParameters['PROPERTY_OBJECTIVE'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_OBJECTIVE'),
        'VALUES' => $arPropertiesString
    );

    $arTemplateParameters['PROPERTY_SERVICES'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_SERVICES'),
        'VALUES' => $arPropertiesLink
    );

    $arTemplateParameters['PROPERTY_IMAGES'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_IMAGES'),
        'VALUES' => $arPropertiesFiles
    );

    $arTemplateParameters['PROPERTY_SOLUTION_BEGIN'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_SOLUTION_BEGIN'),
        'VALUES' => $arPropertiesString
    );

    $arTemplateParameters['PROPERTY_SOLUTION_IMAGE'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_SOLUTION_IMAGE'),
        'VALUES' => $arPropertiesFile
    );

    $arTemplateParameters['PROPERTY_SOLUTION_END'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_SOLUTION_END'),
        'VALUES' => $arPropertiesString
    );
}

if (!empty($iIBlockIdReviews)) {
    $arProperties = array();
    $arPropertiesLink = array();
    $rsProperties = CIBlockProperty::GetList(array('SORT' => 'ASC'), array(
        'IBLOCK_ID' => $iIBlockIdReviews,
        'ACTIVE' => 'Y'
    ));

    while ($arProperty = $rsProperties->GetNext()) {
        $sCode = $arProperty['CODE'];

        if (empty($sCode))
            continue;

        $sName = '['.$arProperty['CODE'].'] '.$arProperty['NAME'];

        if ($arProperty['MULTIPLE'] != 'Y')
            if ($arProperty['PROPERTY_TYPE'] == 'E')
                $arPropertiesLink[$sCode] = $sName;

        $arProperties[$arProperty['CODE']] = $arProperty;
    }

    $arTemplateParameters['PROPERTY_REVIEW'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('N_PROJECTS_PARAMETERS_PROPERTY_REVIEW'),
        'VALUES' => $arPropertiesLink
    );
}
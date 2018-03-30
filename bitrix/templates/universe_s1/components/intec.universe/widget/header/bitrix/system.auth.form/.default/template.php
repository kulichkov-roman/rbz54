<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 */

if (!CModule::IncludeModule('intec.core'))
    return;

$this->setFrameMode(true);
$sTemplateId = spl_object_hash($this);
$sFormType = $arResult['FORM_TYPE'];

$authParams = $arParams;
$authParams['AJAX_MODE'] = 'N';
$authParams['AUTH_URL'] = $arParams["LOGIN_URL"];
$authParams["AUTH_FORGOT_PASSWORD_URL"] = $arParams["FORGOT_PASSWORD_URL"];
$authParams["AUTH_REGISTER_URL"] = $arParams["REGISTER_URL"];

$oFrame = $this->createFrame();
$oFrame->begin();
?>
    <div class="header-info-authorization" id="<?= $sTemplateId ?>">
        <?php if ($sFormType == 'login') { ?>
            <div class="header-info-button" data-action="login">
                <div class="intec-aligner"></div>
                <div class="header-info-button-icon glyph-icon-login_2 intec-cl-text"></div>
                <div class="header-info-button-text">
                    <?= GetMessage('W_HEADER_S_A_F_LOGIN') ?>
                </div>
            </div>
        <?php } else { ?>
            <a href="<?= $arResult['PROFILE_URL'] ?>" class="header-info-button">
                <div class="intec-aligner"></div>
                <div class="header-info-button-icon glyph-icon-user_2 intec-cl-text"></div>
                <?php if ($arParams['FIXED'] != 'Y' ) {?>
                    <div class="header-info-button-text">
                        <?= $arResult['USER_LOGIN'] ?>
                    </div>
                <?}?>
            </a>
            <?php if ($arParams['FIXED'] != 'Y' ) {?>
                <a href="<?= $arResult['LOGOUT_URL'] ?>" class="header-info-button">
                    <div class="intec-aligner"></div>
                    <div class="header-info-button-icon glyph-icon-logout_2 intec-cl-text"></div>
                    <div class="header-info-button-text">
                        <?= GetMessage('W_HEADER_S_A_F_LOGOUT') ?>
                    </div>
                </a>
            <?php }?>
        <?php } ?>
        <?php if (!defined('EDITOR')) { ?>
            <script type="text/javascript">
                (function ($, api) {
                    var root = $(<?= JavaScript::toObject('#'.$sTemplateId) ?>);
                    var buttons = {
                        'login': root.find('[data-action=login]')
                    };

                    buttons.login.on('click', function () {
                        universe.components.show(<?= JavaScript::toObject([
                            'component' => 'bitrix:system.auth.authorize',
                            'template' => 'popup',
                            'parameters' => $authParams,
                            'settings' => [
                                'width' => 800,
                                'title' => GetMessage('W_HEADER_S_A_F_AUTH_FORM_TITLE')
                            ]
                        ]) ?>);
                    });
                })(jQuery, intec);
            </script>
        <?php } ?>
    </div>
<?php $oFrame->end(); ?>
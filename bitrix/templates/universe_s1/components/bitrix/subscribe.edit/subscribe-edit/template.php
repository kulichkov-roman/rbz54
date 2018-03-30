<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <?
        foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
            echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
        foreach($arResult["ERROR"] as $itemID=>$itemValue)
            echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));
        if($arResult["ALLOW_ANONYMOUS"]=="N" && !$USER->IsAuthorized()):
            echo ShowMessage(array("MESSAGE"=>GetMessage("CT_BSE_AUTH_ERR"), "TYPE"=>"ERROR"));
        else:
        ?>
        <div class="subscribe-block">
            <h4><?= GetMessage('INFORMATION_SUBSCRIBE_HEADER') ?></h4>
            <div class="subscribe-form">
                <form action="<?=$arResult["FORM_ACTION"]?>" method="post">
                    <?echo bitrix_sessid_post();?>
                    <input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
                    <input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
                    <input type="hidden" name="RUB_ID[]" value="0" />

                    <?if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
                        <div class="subscription-utility">
                            <div><?echo GetMessage("CT_BSE_CONF_NOTE")?></div>
                            <div class="uni-indents-vertical indent-5"></div>
                            <div><?echo GetMessage("CT_BSE_CONF_NOTE1")?></div>
                            <div class="uni-indents-vertical indent-10"></div>
                            <input class="uni-input-text" name="CONFIRM_CODE" type="text" class="subscription-textbox" value="<?echo GetMessage("CT_BSE_CONFIRMATION")?>" onblur="if (this.value=='')this.value='<?echo GetMessage("CT_BSE_CONFIRMATION")?>'" onclick="if (this.value=='<?echo GetMessage("CT_BSE_CONFIRMATION")?>')this.value=''" />
                            <div class="uni-indents-vertical indent-40"></div>
                            <input class="uni-button solid_button" type="submit" name="confirm" value="<?echo GetMessage("CT_BSE_BTN_CONF")?>" />
                        </div>
                        <div class="uni-indents-vertical indent-40"></div>
                        <div class="uni-indents-vertical indent-40"></div>
                    <?endif?>

                    <div class="email-block-subscribe row">
                        <div class="form-group required col-md-6">
                            <label><?echo GetMessage("CT_BSE_EMAIL_LABEL")?></label><br/>
                            <input type="email" value="<?echo $arResult["SUBSCRIPTION"]["EMAIL"]!=""? $arResult["SUBSCRIPTION"]["EMAIL"]: $arResult["REQUEST"]["EMAIL"];?>" class="form-control form-control-local" placeholder="<?=GetMessage("CT_BSE_EMAIL")?>"><br/>
                        </div>
                        <div class="subscribe-info col-md-6">
                            <div class="subscribe-info-text">
                                <?echo GetMessage("INFORMATION_SUBSCRIBE")?> <br>
                                <?echo GetMessage("INFORMATION_SUBSCRIBE_NOT_ACTIVE")?>
                            </div>
                        </div>
                    </div>

                    <div class="subscribe-margin-block row">
                        <div class="form-group col-md-4">
                            <h5><?echo GetMessage("CT_BSE_RUBRIC_LABEL")?></h5><br/>
                            <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
                                <div class="subscription-rubric">
                                    <label class="uni-button-checkbox" for="RUBRIC_<?echo $itemID?>">
                                        <input type="checkbox" id="RUBRIC_<?echo $itemID?>" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> />
                                        <div class="selector"></div>
                                        <div class="text"><?echo $itemValue["NAME"]?></div>
                                    </label>
                                </div>
                            <?endforeach;?>
                            <?if($arResult["ID"]==0):?>
                            <?else:?>
                                <div class="uni-indents-vertical indent-10"></div>
                                <div class="subscription-notes"><?echo GetMessage("CT_BSE_EXIST_NOTE")?></div>
                            <?endif?>
                        </div>
                        <div class="form-group col-md-8 radio-block">
                            <h5><?echo GetMessage("CT_BSE_FORMAT_LABEL")?></h5>
                            <div class="radio">
                                <input id="MAIL_TYPE_TEXT" type="radio" name="FORMAT" value="text" <?if($arResult["SUBSCRIPTION"]["FORMAT"] != "html") echo "checked"?>>
                                <label for="MAIL_TYPE_TEXT"></label><span><?echo GetMessage("CT_BSE_FORMAT_TEXT")?></span>
                                <input id="MAIL_TYPE_HTML" type="radio" name="FORMAT" value="html" <?if($arResult["SUBSCRIPTION"]["FORMAT"] != "html") echo "checked"?>>
                                <label for="MAIL_TYPE_HTML"></label><span><?echo GetMessage("CT_BSE_FORMAT_HTML")?></span>
                            </div>

                        </div>
                    </div>
                    <div class="subscribe-margin-block ">
                        <div class=" ">
                            <input type="submit" disabled id="register_submit" name="register_submit_button" class="intec-button intec-button-s-7 intec-button-cl-common" value="Добавить" style="font-weight: 400;" onclick="SubmitClick();">
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" onchange="disabledSubmit();" id="agree-checkbox">
                            <label for="agree-checkbox">
                                <?= GetMessage('INFORMATION_SUBSCRIBE_CONTEST_1') ?>
                                <a class="intec-cl-text intec-cl-text-light-hover" href="<?= SITE_DIR ?>contest/"><?= GetMessage('INFORMATION_SUBSCRIBE_CONTEST_2') ?></a>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?endif;?>
    </div>
</div>


<script>
    function disabledSubmit()
    {
        if($("#agree-checkbox").is(':checked'))
            $('#register_submit').removeAttr('disabled');
        else
            $('#register_submit').attr('disabled','disabled');
    }

    function SubmitClick(){
        $('#login-registration').val($('#email-registration').val());
    }
</script>
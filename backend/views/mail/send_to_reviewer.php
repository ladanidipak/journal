<?php
use yii\helpers\Url;
use backend\vendors\Common;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>

    <style type="text/css">@media only screen and (max-width:480px){body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:none !important}body{width:100% !important;min-width:100% !important}td[id=bodyCell]{padding:10px !important}table.kmMobileHide{display:none !important}table[class=kmTextContentContainer]{width:100% !important}table[class=kmBoxedTextContentContainer]{width:100% !important}td[class=kmImageContent]{padding-left:0 !important;padding-right:0 !important}img[class=kmImage]{width:100% !important}td.kmMobileStretch{padding-left:0 !important;padding-right:0 !important}table[class=kmSplitContentLeftContentContainer],table[class=kmSplitContentRightContentContainer],table[class=kmColumnContainer],td[class=kmVerticalButtonBarContentOuter] table[class=kmButtonBarContent],td[class=kmVerticalButtonCollectionContentOuter] table[class=kmButtonCollectionContent],table[class=kmVerticalButton],table[class=kmVerticalButtonContent]{width:100% !important}td[class=kmButtonCollectionInner]{padding-left:9px !important;padding-right:9px !important;padding-top:9px !important;padding-bottom:0 !important;background-color:transparent !important}td[class=kmVerticalButtonIconContent],td[class=kmVerticalButtonTextContent],td[class=kmVerticalButtonContentOuter]{padding-left:0 !important;padding-right:0 !important;padding-bottom:9px !important}table[class=kmSplitContentLeftContentContainer] td[class=kmTextContent],table[class=kmSplitContentRightContentContainer] td[class=kmTextContent],table[class=kmColumnContainer] td[class=kmTextContent],table[class=kmSplitContentLeftContentContainer] td[class=kmImageContent],table[class=kmSplitContentRightContentContainer] td[class=kmImageContent]{padding-top:9px !important}td[class="rowContainer kmFloatLeft"],td[class="rowContainer kmFloatLeft firstColumn"],td[class="rowContainer kmFloatLeft lastColumn"]{float:left;clear:both;width:100% !important}table[id=templateContainer],table[class=templateRow]{max-width:600px !important;width:100% !important}h1{font-size:40px !important;line-height:130% !important}h2{font-size:32px !important;line-height:130% !important}h3{font-size:24px !important;line-height:130% !important}h4{font-size:18px !important;line-height:130% !important}td[class=kmTextContent]{font-size:14px !important;line-height:130% !important}td[class=kmTextBlockInner] td[class=kmTextContent]{padding-right:18px !important;padding-left:18px !important}table[class="kmTableBlock kmTableMobile"] td[class=kmTableBlockInner]{padding-left:9px !important;padding-right:9px !important}table[class="kmTableBlock kmTableMobile"] td[class=kmTableBlockInner] [class=kmTextContent]{font-size:14px !important;line-height:130% !important;padding-left:4px !important;padding-right:4px !important}}</style>
</head>
<body style="margin:0;padding:0;background-color:#eee">
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:0;background-color:#eee;height:100%;margin:0;width:100%">
        <tbody>
        <tr>
            <td align="center" id="bodyCell" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-top:10px;padding-left:20px;padding-bottom:20px;padding-right:20px;border-top:0;height:100%;margin:0;width:100%">
                <table border="0" cellpadding="0" cellspacing="0" id="templateContainer" width="600" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;border:0 none #aaa;background-color:#fff;border-radius:0">
                    <tbody>
                    <tr>
                        <td id="templateContainerInner" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:0">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmImageBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmImageBlockOuter">
                                                        <tr>
                                                            <td class="kmImageBlockInner" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:9px;" valign="top">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmImageContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="kmImageContent" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:0;padding-top:0px;padding-bottom:0;padding-left:9px;padding-right:9px;text-align: center;">
                                                                            <a href="http://www.grdjournals.com/" target="_self" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline">
                                                                                <img align="center" alt="GRD Journals - Logo" class="kmImage" src="https://d3k81ch9hvuctc.cloudfront.net/company/muWbV5/images/9fae59a0-99b7-4aa5-89ae-06d13468607d.png" width="171" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;padding-bottom:0;display:inline;vertical-align:bottom;max-width:171px;" />
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmTextBlockOuter">
                                                        <tr>
                                                            <td class="kmTextBlockInner" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="kmTextContent" valign="top" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:130%;text-align:left;padding-top:9px;padding-bottom:9px;padding-left:18px;padding-right:18px;'>
                                                                            <p style="margin:0;padding-bottom:1em;text-align: center;"><strong><span style="color:#A9A9A9;"><span style="font-size:20px;">Global Research and Development Journal for Engineering(GRDJE)</span></span></strong></p>
                                                                            <p style="margin:0;padding-bottom:0;text-align: center;"><span style="line-height: 20.8px; text-align: center; font-family: 'Helvetica Neue', Arial; font-size: 14px; color: rgb(165, 42, 42);"><strong>ISSN (online) :</strong></span><span style="line-height: 20.8px; text-align: center; font-family: 'Helvetica Neue', Arial; font-size: 14px;"> <span style="color: rgb(178, 34, 34);"><strong>2455-5703</strong></span></span></p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmTextBlockOuter">
                                                        <tr>
                                                            <td class="kmTextBlockInner" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="kmTextContent" valign="top" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:130%;text-align:left;padding-top:18px;padding-bottom:0px;padding-left:15px;padding-right:15px;'>
                                                                            <p style="margin:0;padding-bottom:0"><b>Review the manuscript - <?= date('d/m/Y')?></b></p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft firstColumn" valign="top" width="33%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                </td>
                                                <td class="rowContainer kmFloatLeft" valign="top" width="33%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                </td>
                                                <td class="rowContainer kmFloatLeft lastColumn" valign="top" width="33%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmTextBlockOuter">
                                                        <tr>
                                                            <td class="kmTextBlockInner" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="kmTextContent" valign="top" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:130%;text-align:left;padding-top:18px;padding-bottom:18px;padding-left:15px;padding-right:15px;'>
                                                                            <p style="margin:0;padding-bottom:1em"><?= $reviewer->full_name; ?></p>
                                                                            <p style="margin:0;padding-bottom:1em">As per our discussion earlier, you agreed upon reviewing the article. We therefore sending you the article copy for reviewing. Please find the attached article for reviewing.</p>
                                                                            <p style="margin:0;padding-bottom:1em">Here are some primary details of article.</p>
                                                                            <p style="margin:0;padding-bottom:1em"><strong>Article Title :</strong> <?= $article->article_title; ?></p>
                                                                            <p style="margin:0;padding-bottom:1em"><strong>Branch :</strong> <?= ($article->branch_id == "13") ? $article->branch_name : $article->branch->name?></p>
                                                                            <p style="margin:0;padding-bottom:1em"><strong>Research Area :</strong> <?= $article->research_area; ?></p>
                                                                            <p style="margin:0;padding-bottom:1em"><strong>Type :</strong> <?= $article->type->name; ?></p>
                                                                            <p style="margin:0;padding-bottom:1em">After reviewing the article, you have to submit the review report in the form appearing after clicking the button below. Please make sure you have to submit the review report within 3 days.</p>
                                                                            <p style="margin:0;padding-bottom:0"><strong></strong></p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="kmButtonBlock" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmButtonBlockOuter">
                                                        <tr>
                                                            <td valign="top" align="center" class="kmButtonBlockInner" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding:9px 18px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="kmButtonContentContainer" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;border-top-left-radius:5px;border-top-right-radius:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;background-color:#999;background-color:#C1292B;border-radius:5px;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="middle" class="kmButtonContent" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:white;font-family:"Helvetica Neue", Arial;font-size:16px;padding:15px;padding-top:15px;padding-bottom:15px;padding-left:15px;padding-right:15px;color:#ffffff;font-weight:bold;font-size:16px;font-family:"Helvetica Neue", Arial;'>
                                                                            <a class="kmButton" title="" href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['open/rfeedback','id'=>  Common::passencrypt($rid)])?>" target="_blank" style='word-wrap:break-word;font-weight:normal;letter-spacing:-0.5px;line-height:100%;text-align:center;text-decoration:underline;color:#15C;font-family:"Helvetica Neue", Arial;font-size:16px;text-decoration:initial;color:#ffffff;font-weight:bold;font-size:16px;font-family:"Helvetica Neue", Arial;padding-top:0;padding-bottom:0;'>Click to submit your review</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmTextBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmTextBlockOuter">
                                                        <tr>
                                                            <td class="kmTextBlockInner" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="kmTextContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="kmTextContent" valign="top" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222;font-family:"Helvetica Neue", Arial;font-size:14px;line-height:130%;text-align:left;padding-top:9px;padding-bottom:9px;padding-left:18px;padding-right:18px;'>
                                                                            <p style="margin:0;padding-bottom:1em;line-height: 20.8px;">Feel free to reach us if any queries. </p>
                                                                            <p style="margin:0;padding-bottom:1em;line-height: 20.8px;"> </p>
                                                                            <p style="margin:0;padding-bottom:1em;font-family: arial, sans-serif; font-size: 12.8px; line-height: normal;"><strong>Sincerely,</strong></p>
                                                                            <p style="margin:0;padding-bottom:1em;font-family: arial, sans-serif; font-size: 12.8px; line-height: normal;"><strong>Global Research and Development Journals (GRD Journals)</strong></p>
                                                                            <p style="margin:0;padding-bottom:1em;line-height: 20.8px;"><span style="line-height: 1.6em;">Email: </span><a href="mailto:info@grdjournals.com" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline;line-height: 1.6em;">info@grdjournals.com</a></p>
                                                                            <p style="margin:0;padding-bottom:1em;line-height: 20.8px;"><span style="line-height: 1.6em;">Phone: </span><a href="file:///C:/Users/Divyang%20Shah/AppData/Local/Temp/Rar%24DIa0.399/+917405407107" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline;line-height: 1.6em;">+91 740 540 7107</a></p>
                                                                            <p style="margin:0;padding-bottom:1em;line-height: 20.8px; text-align: center;"><a href="http://www.grdjournals.com/" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline">www.grdjournals.com</a></p>
                                                                            <p style="margin:0;padding-bottom:0;line-height: 20.8px; text-align: center;"><span style="color: rgb(169, 169, 169);">GRD Journals - Redefining Research </span></p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                        <table border="0" cellpadding="0" cellspacing="0" class="templateRow" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                            <tbody>
                                            <tr>
                                                <td class="rowContainer kmFloatLeft" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarBlock" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                        <tbody class="kmButtonBarOuter">
                                                        <tr>
                                                            <td class="kmButtonBarInner" align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-top:20px;padding-bottom:9px;background-color:#eeeeee;padding-left:9px;padding-right:9px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContentContainer" width="100%" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="center" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-left:9px;padding-right:9px;">
                                                                            <table border="0" cellpadding="0" cellspacing="0" class="kmButtonBarContent" style='border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;font-family:"Helvetica Neue", Arial'>
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                                        <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-right:10px;">
                                                                                                                <a href="https://twitter.com/grdjournals" target="_blank" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/twitter_48.png" alt="Twitter" class="kmButtonBlockIcon" width="48" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;width:48px; max-width:48px; display:block;" /></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]></td><td align="left" valign="top"><![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                                        <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-right:10px;">
                                                                                                                <a href="https://www.facebook.com/grdjournals" target="_blank" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/facebook_48.png" alt="Facebook" class="kmButtonBlockIcon" width="48" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;width:48px; max-width:48px; display:block;" /></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]></td><td align="left" valign="top"><![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                                        <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;padding-right:10px;">
                                                                                                                <a href="http://grdjournals.blogspot.in/" target="_blank" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/rss_48.png" alt="Blog" class="kmButtonBlockIcon" width="48" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;width:48px; max-width:48px; display:block;" /></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]></td><td align="left" valign="top"><![endif]-->
                                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0">
                                                                                                        <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
                                                                                                                <a href="https://plus.google.com/+grdjournals" target="_blank" style="word-wrap:break-word;color:#15C;font-weight:normal;text-decoration:underline"><img src="https://d3k81ch9hvuctc.cloudfront.net/assets/email/buttons/subtle/google_plus_48.png" alt="Google Plus" class="kmButtonBlockIcon" width="48" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;width:48px; max-width:48px; display:block;" /></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <!--[if gte mso 6]></td><td align="left" valign="top"><![endif]-->
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</center>
</body>
</html>
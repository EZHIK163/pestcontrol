<?php
$this->title = "Вызов бригады пестконтроля {$name_customer}"; ?>
<div class="row-fluid">
            <div id="sidebar" class="span3">
                <div class="sidebar-nav">
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_admin]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_manager]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_report]) ?>
                </div>
            </div>
            <main id="content" role="main" class="span9">
                <div id="system-message-container">
                </div>

                <div class="item-page" itemscope="" itemtype="http://schema.org/Article">
                    <meta itemprop="inLanguage" content="ru-RU">


                    <div class="page-header">
                        <h2 itemprop="name"><?= $this->title ?></h2>
                    </div>

                    <div itemprop="articleBody">

                        <div class="contact-form">
                            <form id="contact-form" action="/vykhoz-brigady-pestkontrolya" method="post" class="form-validate form-horizontal">
                                <fieldset>
                                    <legend>Отправить сообщение. Все поля, отмеченные звездочкой, являются обязательными.</legend>
                                    <div class="control-group">
                                        <div class="control-label"><label id="jform_contact_name-lbl" for="jform_contact_name" class="hasTooltip required" title="&lt;strong&gt;Имя&lt;/strong&gt;&lt;br /&gt;Ваше имя">
                                                Имя<span class="star">&#160;*</span></label></div>
                                        <div class="controls"><input type="text" name="jform[contact_name]" id="jform_contact_name" value="" class="required" size="30" required aria-required="true" /></div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"><label id="jform_contact_email-lbl" for="jform_contact_email" class="hasTooltip required" title="&lt;strong&gt;E-mail&lt;/strong&gt;&lt;br /&gt;Адрес электронной почты контакта">
                                                E-mail<span class="star">&#160;*</span></label></div>
                                        <div class="controls"><input type="email" name="jform[contact_email]" class="validate-email required" id="jform_contact_email" value="" size="30" required aria-required="true" /></div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"><label id="jform_contact_emailmsg-lbl" for="jform_contact_emailmsg" class="hasTooltip required" title="&lt;strong&gt;Тема&lt;/strong&gt;&lt;br /&gt;Тема сообщения">
                                                Тема<span class="star">&#160;*</span></label></div>
                                        <div class="controls"><input type="text" name="jform[contact_subject]" id="jform_contact_emailmsg" value="" class="required" size="60" required aria-required="true" /></div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"><label id="jform_contact_message-lbl" for="jform_contact_message" class="hasTooltip required" title="&lt;strong&gt;Сообщение&lt;/strong&gt;&lt;br /&gt;Введите текст вашего сообщения">
                                                Сообщение<span class="star">&#160;*</span></label></div>
                                        <div class="controls"><textarea name="jform[contact_message]" id="jform_contact_message" cols="50" rows="10" class="required" required aria-required="true" ></textarea></div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"><label id="jform_contact_email_copy-lbl" for="jform_contact_email_copy" class="hasTooltip" title="&lt;strong&gt;Отправить копию этого сообщения на ваш адрес&lt;/strong&gt;&lt;br /&gt;Отправляет копию данного сообщения на указанный вами адрес.">
                                                Отправить копию этого сообщения на ваш адрес</label></div>
                                        <div class="controls"><input type="checkbox" name="jform[contact_email_copy]" id="jform_contact_email_copy" value="1" /></div>
                                    </div>


                                        <button class="btn btn-primary validate" type="submit">Отправить сообщение</button>

                                </fieldset>
                            </form>
                        </div>

                        <h3>Дополнительная информация</h3>
                        <div class="contact-miscinfo">
					<span class="contact-misc">
						<span style="color: #ff0000;">
                            <strong>
                                <span style="font-size: 12pt;">Обязательно указывайте город нахождения предприятия!</span>
                            </strong>
                        </span>

                    </span>
                        </div>



                    </div>


                <!-- End Content -->
            </main>
</div>

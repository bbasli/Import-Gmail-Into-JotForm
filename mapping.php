<!DOCTYPE html>
<html>
<head>
    <title>Mapping Page</title>
    <link rel="stylesheet" type="text/css" href="mapping.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/442b87c1e1.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include "header2.html" ?>

<svg class="svg">
    <line id="subject-line"/>
</svg>
<svg class="svg">
    <line id="name-line"/>
</svg>
<svg class="svg">
    <line id="address-line"/>
</svg>
<svg class="svg">
    <line id="content-line"/>
</svg>
<svg class="svg">
    <line id="date-line"/>
</svg>
<div class="main">
    <iframe id="myFrame" class="form-preview" src="form.html">
    </iframe>
    <div class="email">
        <div class="email-header">
                    <span class="email-subject field mr-10 u-ptb2-prl7">Test Email Subject
                    <input id="subject" type="checkbox"/>
                    </span>
            <div class="email-star mr-10"><i class="fas fa-star"></i></div>
            <div class="email-label">Inbox &nbsp;<i class="fas fa-times"></i></div>
            <div class="printer-icon"><i class="fas fa-print"></i></div>
        </div>
        <div class="email-main">
            <i class="fas fa-user-circle user-avatar"></i>
            <div>
                <div class="email-body-header">
                    <div class="email-body-header-top">
                        <div class="email-sender">
                            <div class="email-sender-name field u-ptb2-prl7">
                                Buğra Baslı
                                <input id="name" type="checkbox"/>
                            </div>
                            <div class="email-address field u-ptb2-prl7">
                                &lt;bgrbasli@gmail.com&gt;
                                <input id="address" type="checkbox"/>
                            </div>
                        </div>
                        <div class="email-header-others">
                            <div class="email-date field u-ptb2-prl7">
                                6:41 PM (10 minutes ago)
                                <input id="date" type="checkbox"/>
                            </div>
                            <i class="far fa-star"></i>
                            <i class="fas fa-reply"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                    <div class="email-body-header-bottom">
                        to me &nbsp;
                        <i class="fas fa-caret-down"></i>
                    </div>
                </div>
                <div class="email-content field">
                    <input id="content" type="checkbox"/>
                    <p class="email-body-content-text">
                        This is the beginning of the email content,<br/><br/>

                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since the 1500s, when an unknown printer took a galley of type and
                        scrambled it to make a type specimen book.<br/><br/>

                        It has survived not only five centuries, but also the leap into
                        electronic typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the release of Letraset sheets
                        containing Lorem Ipsum passages, and more recently with desktop
                        publishing software like Aldus PageMaker including versions of Lorem
                        Ipsum.
                    </p>
                    <br/>
                    <img class="email-content-img"
                         src="https://static.daktilo.com/sites/449/uploads/2020/09/24/large/%C3%A7a%C4%9Flayan-manzara-resmi.jpg"/>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="nextButton" onclick="checkMapping()">NEXT</button>
</body>
<script src="connectFields.js"></script>
</html>
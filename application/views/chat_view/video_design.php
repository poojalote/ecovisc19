<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"-->
    <!--          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
    <link href="<?= base_url() ?>assets/scripts/toastr/toastr.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>assets/scripts/toastr/toastr.css" rel="stylesheet" type="text/css"/>
    <style>
        /*.main-container {*/
        /*    display: flex;*/
        /*    flex-direction: column;*/
        /*    width: 100%;*/
        /*    height: 100vh;*/
        /*}*/
        /*.items-list {*/
        /*    display: flex;*/
        /*    flex-direction: row;*/
        /*}*/

        /*.item {*/
        /*    width: 100%;*/
        /*    height: calc(100vw * 1.72);*/
        /*}*/


        body {
            color: #000;
            font-family: "Roboto", sans-serif;
            font-size: 18px;
            font-weight: 400;
            line-height: 1.6;
        }

        .container {
            max-width: 1335px;
            margin: 0 auto;
        }

        .grid-row {
            display: flex;
            flex-flow: row wrap;
            justify-content: space-around;
        }

        .grid-item {
            height: calc(100vw * 1.72);
            flex-basis: 20%;
            -ms-flex: auto;
            width: 250px;
            position: relative;
            padding: 10px;
            box-sizing: border-box;
        }

        .grid-row a {
            text-decoration: none;
        }

        .wrapping-link {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 2;
            color: currentColor;
        }

        .grid-item-wrapper {
            -webkit-box-sizing: initial;
            -moz-box-sizing: initial;
            box-sizing: initial;
            background: #aaa;
            margin: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            -webkit-transition: padding 0.15s cubic-bezier(0.4, 0, 0.2, 1), margin 0.15s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            transition: padding 0.15s cubic-bezier(0.4, 0, 0.2, 1), margin 0.15s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .grid-item-container {
            height: 100%;
            width: 100%;
            position: relative;
        }

        .grid-image-top {
            height: 45%;
            width: 120%;
            background-size: cover;
            position: relative;
            background-position: 50% 50%;
            left: -10.5%;
            top: -4.5%;
            display: none;
        }

        .grid-image-top .centered {
            text-align: center;
            transform: translate(-50%, -50%);
            background-size: contain;
            background-repeat: no-repeat;
            position: absolute;
            top: 54.5%;
            left: 50%;
            width: 60%;
            height: 60%;
            background-position: center;
        }

        .grid-item-content {
            padding: 0 20px 20px 20px;
        }

        .item-title {
            font-size: 24px;
            line-height: 26px;
            font-weight: 700;
            margin-bottom: 18px;
            display: block;
        }

        .item-category {
            text-transform: uppercase;
            display: block;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .item-excerpt {
            margin-bottom: 20px;
            display: block;
            font-size: 14px;
        }

        .more-info {
            position: absolute;
            bottom: 0;
            margin-bottom: 25px;
            padding-left: 0;
            transition-duration: .5s;
            font-size: 12px;
            display: flex;
        }

        .more-info i {
            padding-left: 5px;
            transition-duration: .5s;
        }

        .grid-item:hover .more-info i {
            padding-left: 20px;
            transition-duration: .5s;
        }

        .more-info i::before {
            font-size: 16px;
        }

        .grid-item:hover .grid-item-wrapper {
            padding: 2% 2%;
            margin: -2% -2%;
        }

        @media (max-width: 1333px) {
            .grid-item {
                flex-basis: 49.33%;
            }
        }

        @media (max-width: 1073px) {
            .grid-item {
                flex-basis: 49.33%;
            }
        }

        @media (max-width: 815px) {
            .grid-item {
                flex-basis: 50%;
            }
        }

        @media (max-width: 620px) {
            .col {
                clear: both;
                float: none;
                margin-left: auto;
                margin-right: auto;
                width: auto !important;
            }
        }

        @media (max-width: 555px) {
            .grid-item {
                flex-basis: 100%;
            }
        }
    </style>
</head>
<body>
<!--<div class="main-container">-->
<!---->
<!--    <div class="items-list">-->
<!--        <div class="item" style="background-color: antiquewhite">-->
<!--            <div class="element">-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="item" style="background-color: aliceblue">-->
<!--            <div class="element">-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="item" style="background-color: aqua">-->
<!--            <div class="element">-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="container">
    <div class="grid-row">
        <div class="grid-item">
            <div class="grid-item-wrapper">
                <div class="grid-item-container">
                    <div class="grid-image-top rex-ray">
                        <span class="centered project-image-bg rex-ray-image"></span>
                    </div>

                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="grid-item-wrapper">
                <div class="grid-item-container">
                    <div class="grid-image-top rex-ray">
                        <span class="centered project-image-bg rex-ray-image"></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
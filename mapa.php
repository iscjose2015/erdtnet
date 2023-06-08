<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Timeline</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Rancho&family=Water+Brush&display=swap');
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .main{
            width: 100%;
            height: auto;
            background-color: rgb(245, 245, 245);
            font-family: poppins;
            padding: 50px 0;
            display: grid;
            place-items: center;
        }
        .main .heading{
            font-size: 27px;
            font-weight: 500;
            color: rgb(106, 6, 236);
            position: relative;
            margin-bottom: 80px;
        }
        .heading::after{
            content: " ";
            position: absolute;
            width: 50%;
            height: 4px;
            left: 50%;
            bottom: -5px;
            background-image: linear-gradient(to right, rgb(106, 6, 236), rgb(220, 0, 240));
            transform: translateX(-50%);
        }

        /* Container Css Start  */

        .container{
            width: 70%;
            height: auto;
            position: relative;
        }
        .container ul::after{
            position: absolute;
            content: '';
            width: 2px;
            height: 100%;
            background-image: linear-gradient(to right, rgb(106, 6, 236), rgb(220, 0, 240));
        }
        .container ul{
            list-style: none;
        }
        .container ul li{
            width: 50%;
            height: auto;
            padding: 15px 20px;
            background-color: #fff;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 4px 4px 25px rgba(51, 51, 51, 0.192);
            position: relative;
            z-index: 99;
        }
        .container ul li:nth-child(odd){
            float: left;
            clear: right;
            transform: translateX(-30px);
        }
        .container ul li:nth-child(odd) .date{
            right: 20px;
        }
        .container ul li:nth-child(even){
            float: right;
            clear: left;
            transform: translateX(30px);
        }
        .container ul li:nth-child(4){
            margin-bottom: 0;
        }
        .container ul li .title{
            font-size: 20px;
            font-weight: 500;
            color: rgb(106, 6, 236);
        }
        ul li p{
            font-size: 15px;
            color: #444;
            margin: 7px 0;
            line-height: 23px;
        }
        ul li a{
            font-size: 15px;
            color: rgb(106, 6, 236);
            text-decoration: none;
        }
        ul li .date{
            position: absolute;
            top: -45px;
            width: 135px;
            height: 35px;
            border-radius: 20px;
            color: #fff;
            background-image: linear-gradient(to right, rgb(106, 6, 236), rgb(220, 0, 240));
            display: grid;
            place-items: center;
            font-size: 14px;
        }
        .container ul li .circle{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(220, 0, 240, 0.401);
            position: absolute;
            top: 0;
        }
        .container ul li .circle::after{
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: rgb(106, 6, 236);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container ul li:nth-child(odd) .circle{
            right: -30px;
            transform: translate(50%, -50%);
        }
        .container ul li:nth-child(even) .circle{
            left: -30px;
            transform: translate(-50%, -50%);
        }

        /*  Media Query Started  */

        @media screen and (max-width:1224px){
            .container{
                width: 85%;
            }
        }

        @media screen and (max-width:993px){
            .container{
                width: 80%;
                transform: translateX(15px);
            }
            .container ul::after{
                left: -30px;
            }
            .container ul li{
                width: 100%;
                float: none;
                clear: none;
                margin-bottom: 80px;
            }
            .container ul li:nth-child(odd){
                text-align: left;
                transform: translateX(0);
            }
            .container ul li:nth-child(odd) .date{
                left: 20px;
            }
            .container ul li:nth-child(odd) .circle{
                left: -30px;
                transform: translate(-50%, -50%);
            }
            .container ul li:nth-child(even){
                transform: translateX(0);
            }
        }

    </style>

</head>

<body>
    <div class="main">
        <h3 class="heading">Mapa del Contrato</h3>

        <div class="container">
            <ul>

                <?php for ($k=0;  $k<= 4;  $k++) { ?>

                <li>
                    <h3 class="title">Front End Developer</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eaque quidem esse? Incidunt, odit beatae?</p>
                    <a href="#">Read More ></a>
                    <span class="circle"></span>
                    <span class="date">January 2022</span>
                </li>

                <?php

                }


                ?>
                
               
               
            </ul>
        </div>
    </div>

</body>
</html>



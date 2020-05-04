
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>404 Error Page for Questex</title>
    <style>
        html {
            margin:0;
            padding:0;
        }

        body {
            background-color:#395D6D;
            margin:auto;
        }

        .button a {
            text-decoration: none;
            color:#395D6D;
        }

        .container {
            margin:auto;
            width:80%;
            text-align: center;
            position:relative;
            height:100vh;

        }

        .text {
            width: 40%;
            text-align: center;
            z-index: 0;
            position:absolute;
            background-color:white;
            padding: 3rem;
            left:0;
            right:0;
            border-radius:25px;
            margin-right: auto;
            margin-left: auto;
            top:30%;
            box-shadow: 7px 7px 10px #27414C;
            justify-content: space-around;
            align-items:center;
            flex-wrap:wrap;

        }

        h1 {
            font-family: 'Lato', sans-serif;
            font-weight: 900;
            font-size:2rem;
            text-align:center;
            margin:auto;
            color:#395D6D;
            letter-spacing: .10rem;
            padding-bottom:.5rem;
        }

        h2 {
            font-family: 'Lato', sans-serif;
            font-weight: 400;
            font-size:1rem;
            text-align:center;
            margin:auto;
            color:#395D6D;
            letter-spacing: .10rem;
            padding-bottom: 2rem;

        }

        h3 {
            font-family: 'Lato', sans-serif;
            font-weight: 900;
            font-size:.8rem;
            text-align:center;
            text-transform: uppercase;
            margin:auto;
            letter-spacing: .10rem;
        }

        .button {
            width:8rem;
            border:2px solid #395d6d;
            margin:auto;
            border-radius: 25px;
            text-align:center;
            padding:.5rem;
            color:#FCA671;
            cursor: pointer;
            transition: .3s;
        }

        #home:hover {
            color:white!important;
        }

        @media (max-width: 630px) {
            .text {
                width: 60%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="text">
        <div class="text-inner">

            <h1>404 error</h1>

            <h2>Видимо такой страницы не существует</h2>

            <div id="home" class="button">

                    <h3><a href="{{ asset('/') }}">На главную</a></h3>

            </div>

        </div>
    </div>

</div>

</body>

</html>

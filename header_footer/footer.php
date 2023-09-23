<head>
    <style>
        .footer-distributed {
            margin-top: 2rem;
            background: #e1e0e0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
            box-sizing: border-box;
            width: 100%;
            font: bold 16px sans-serif;
            text-align: left;
            padding: 50px 60px 40px;
            overflow: hidden;
        }

        /* Footer left */

        .footer-distributed .footer-left {
            float: left;
        }

        /* The company logo */

        #footer_img {
            height: 60px;
            width: 200px;
        }

        /* Footer links */

        .footer-distributed .footer-links {
            color: #482b61;
            margin: 0 0 10px;
            padding: 0;
        }

        .footer-distributed .footer-links a {
            display: inline-block;
            line-height: 1.8;
            text-decoration: none;
            color: inherit;
        }

        .footer-distributed .footer-company-name {
            color: #8f9296;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
        }

        /* Footer social icons */

        .footer-distributed .footer-icons {
            margin-top: 40px;
        }

        .footer-distributed .footer-icons a {
            display: inline-block;
            width: 35px;
            height: 35px;
            cursor: pointer;
            background-color: #4b2a68;
            border-radius: 2px;

            font-size: 20px;
            text-align: center;
            line-height: 35px;

            margin-right: 3px;
            margin-bottom: 5px;
        }

        /* Footer Right */

        .footer-distributed .footer-right {
            float: right;
        }

        .footer-distributed .footer-right p {
            display: inline-block;
            vertical-align: top;
            margin: 15px 42px 0 0;
            color: #482b61;
        }

        /* The contact form */

        .footer-distributed form {
            display: inline-block;
        }

        .footer-distributed form input,
        .footer-distributed form textarea {
            display: block;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: #482b61;
            box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.1);
            border: none;
            resize: none;

            font: inherit;
            font-size: 14px;
            font-weight: normal;
            color: #d1d2d2;

            width: 400px;
            padding: 18px;
        }

        .footer-distributed ::-webkit-input-placeholder {
            color: #e4e4e4;
        }

        .footer-distributed ::-moz-placeholder {
            color: #5c666b;
            opacity: 1;
        }

        .footer-distributed :-ms-input-placeholder {
            color: #5c666b;
        }

        .footer-distributed form input {
            height: 55px;
            margin-bottom: 15px;
        }

        .footer-distributed form textarea {
            height: 100px;
            margin-bottom: 20px;
        }

        .footer-distributed form button {
            border-radius: 3px;
            background-color: #4b2b79;
            color: #ffffff;
            border: 0;
            padding: 15px 50px;
            font-weight: bold;
            float: right;
        }

        @media (max-width: 1000px) {
            .footer-distributed {
                font: bold 14px sans-serif;
            }

            .footer-distributed .footer-company-name {
                font-size: 12px;
            }

            .footer-distributed form input,
            .footer-distributed form textarea {
                width: 250px;
            }

            .footer-distributed form button {
                padding: 10px 35px;
            }
        }

        @media (max-width: 800px) {
            .footer-distributed {
                padding: 30px;
            }

            .footer-distributed .footer-left,
            .footer-distributed .footer-right {
                float: none;
                max-width: 300px;
                margin: 0 auto;
            }

            .footer-distributed .footer-left {
                margin-bottom: 40px;
            }

            .footer-distributed form {
                margin-top: 30px;
            }

            .footer-distributed form {
                display: block;
            }

            .footer-distributed form button {
                float: none;
            }
        }
    </style>
</head>
<footer id="footer" class="footer-distributed">
    <div class="footer-left">
        <img id="footer_img" src="../imgs/logo.png" />
        <p class="footer-links">
            <a href="#">Accueil</a>
            ·
            <a href="#">Services</a>
            ·
            <a href="#">About</a>
            ·
            <a href="#footer">Contact</a>
        </p>

        <p class="footer-company-name">MyService</p>

        <div class="footer-icons">
            <a href="#"><i><img src="../imgs/facebook-logo.png" /></i></a>
            <a href="#"><i><img src="../imgs/instagram.png" /></i></a>
            <a href="#"><i><img src="../imgs/phone-call.png" /></i></a>
        </div>
    </div>

    <div class="footer-right">
        <p>Contactez-nous</p>

        <form action="#" method="post">
            <input type="text" name="email" placeholder="Email" />
            <textarea name="message" placeholder="Message"></textarea>
            <button>Envoyer</button>
        </form>
    </div>
</footer>
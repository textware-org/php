<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Form with Centered Layout</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .grid-container {
            display: grid;
            grid-template-rows: auto 1fr auto;
            height: 100vh;
        }

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tophead, .content, .footer {
            padding: 20px;
            text-align: center;
        }

        .tophead {
            background-color: #f8f9fa;
        }

        .content {
            background-color: #e9ecef;
            width: 100%;
        }

        .footer {
            background-color: #f8f9fa;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .submit-button, /* Użycie wspólnej klasy dla stylowania */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-button:hover, /* Styl dla wersji hover */
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="grid-container">
    <div class="tophead center-content">
        <h1>Tophead</h1>
    </div>
    <div class="content center-content">
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Your Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Your Email">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" rows="4" placeholder="Your Message"></textarea>
            </div>
            <input type="submit" value="Send" class="submit-button"> <!-- Stylowanie za pomocą klasy -->
        </form>
    </div>
    <div class="footer center-content">
        <p>Footer</p>
    </div>
</div>

</body>
</html>
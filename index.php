<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Generate PHP code for your class definitions quickly and easily. Simply input your class definition and get the generated PHP code instantly.">
    <link rel="shortcut icon" type="image" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <title>Bratif - PHP Class Code Generator</title>
</head>

<body class="bg-dark text-white">
    <nav class="nav container-fluid d-none d-md-block">
        <span class="">
            <strong class="username">
                <a href="index.php" class="ms-3 text-decoration-none text-white" id="username">
                </a>
            </strong>
        </span>
    </nav>

    <h1 class="text-center mt-3">Effortless PHP Class Code Generator</h1>
    <p class="text-center m-3">
        Use this simple tool to automatically generate PHP class code from its definition. Simply enter the class
        definition below and click on <span class="text-primary fw-bold">"Generate"</span> to get the generated code.
    </p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $classDefinition = $_POST["classDefinition"];

        $lines = explode("\n", $classDefinition);

        $attributes = [];
        $construct = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                if (str_starts_with($line, "class")) {
                    $className = explode(" ", str_replace("{", "", $line));
                } elseif (str_starts_with($line, "private") and str_ends_with($line, ";")) {
                    $decomposition = str_replace(";", "", explode(" ", $line));

                    $scope = $decomposition[0];
                    $type = $decomposition[1];
                    $name = str_replace("$", "", $decomposition[2]);
                    $attributes[] = [
                        "scope" => $scope,
                        "type" => $type,
                        "name" => $name
                    ];
                    $construct[] = $type . " $" . $name;
                } else {
                    continue;
                }
            }
        }
    }
    ?>

    <?php if (isset($className)): ?>
        <h2 class="text-center text-success m-2">Generated Code for the Class
            <?= $className[1] ?>
        </h2>


        <div class="container border rounded mb-3">
            <div class="row">
                <div class="col">

                    <!-- Class -->
                    <?= $className[0] . " " . $className[1] ?> <br>
                    {
                    <br>

                    <!-- Attrbibutes -->
                    <?php foreach ($attributes as $attribute): ?>
                        &nbsp;&nbsp;&nbsp;

                        <?= $attribute["scope"] ?>
                        <?= $attribute["type"] ?>
                        <?= "$" . $attribute["name"] ?>; <br>
                    <?php endforeach ?>
                    <br>
                    &nbsp;&nbsp;&nbsp;


                    <!-- Construct -->
                    <?= "public function __construct(" . implode(", ", $construct) . ")" ?>

                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;{<br>

                    <?php foreach ($attributes as $attribute): ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <?= "\$this->" . $attribute["name"] ?> =
                        <?= "$" . $attribute["name"] . ";" ?> <br>
                    <?php endforeach ?>

                    &nbsp;&nbsp;&nbsp;&nbsp;}

                    <br><br><br>

                    <!-- Get and set -->
                    <?php foreach ($attributes as $attribute): ?>
                        &nbsp;&nbsp;&nbsp;

                        <?= "public function get" . ucfirst($attribute["name"]) . "()" ?>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= "return \$this->" . $attribute["name"] ?>; <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                        <br>

                        &nbsp;&nbsp;&nbsp;

                        <?= "public function set" . ucfirst($attribute["name"]) . "(" . $attribute["type"] . " \$" . $attribute["name"] . ")" ?>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= "\$this->" . $attribute["name"] . " = \$" . $attribute["name"] ?>; <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                        <br><br>

                    <?php endforeach ?>
                    }
                </div>
                <div class="col-auto align-self-top">
                    <button class="btn btn-primary" onclick="copyCode()">Copy Code</button>
                </div>
            </div>
        </div>
    <?php endif ?>

    <h2 class="text-center">Class Generation Form</h2>
    <p class="text-center m-3 text-primary">Please ensure you specify variable types in your class definition example
        below.</p>
    <div class="container mb-3">
        <div class="d-flex justify-content-center">
            <form method="post" action="" class="rounded">
                <label for="classDefinition" class="form-label text-center">Class Definition:</label><br>
                <textarea name="classDefinition" id="classDefinition" style="resize: none;" placeholder="class Example {
    private int $age;
    private string $name;
    private string $lastName;
    private string $address;
}" rows="10" cols="30"></textarea><br>

                <input type="submit" value="Generate" class="btn btn-primary w-100">
            </form>
        </div>
    </div>
    <footer class="mt-5 shadow border-top border-danger rounded">
        <?php
        include("./Parsedown.php");
        $Parsedown = new Parsedown();
        $Parsedown->setSafeMode(true);
        ?>
        <div class="m-4 mt-4 mb-2 social-medias-title ">
            <h2>
                <?= $Parsedown->text("Contacts") ?>
            </h2>
        </div>
        <div class="mt-1 mb-2 d-flex flex-wrap justify-content-around">
            <div>
                <span>
                    <?= $Parsedown->text("[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/mamoudou-diallo-528020199/)") ?>
                </span>
            </div>

            <div>
                <span>
                    <?= $Parsedown->text("[![discord](https://img.shields.io/badge/porfolio-orange?style=for-the-badge&logo=web&logoColor=white)](https://portfolio.bratif.com/)") ?>
                </span>
            </div>

            <div>
                <span class="">
                    <?= $Parsedown->text("[![github](https://img.shields.io/badge/github-black?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Mah224Moud)") ?>
                </span>
            </div>

            <div>
                <span>
                    <?= $Parsedown->text("[![discord](https://img.shields.io/badge/blog-red?style=for-the-badge&logo=web&logoColor=white)](https://blog.bratif.com/)") ?>
                </span>
            </div>
        </div>
        <div class="mt-2 mb-2 d-flex flex-wrap justify-content-around">
            <span>
                © Bratif
                <?= date("Y") ?> by Mamoudou
            </span>
        </div>

    </footer>


    <script>
        function copyCode() {

            var codeDiv = document.querySelector('.container.border.rounded.mb-3');
            var range = document.createRange();
            range.selectNode(codeDiv);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);


            try {
                document.execCommand('copy');
                alert('The code has been copied to the clipboard.');
            } catch (err) {
                alert('Copying the code failed.');
            }

            window.getSelection().removeAllRanges();
        }

        function animation() {
            var i = 0;
            var txt = '@mamoudou';
            var speed = 150;
            var eraseDelay = 2500;

            function typeWriter() {
                if (i < txt.length) {
                    document.getElementById("username").innerHTML += txt.charAt(i);
                    i++;
                    setTimeout(typeWriter, speed);
                } else {
                    setTimeout(eraseText, eraseDelay);
                }
            }

            function eraseText() {
                var currentText = document.getElementById("username").innerHTML;
                var textLength = currentText.length;
                if (textLength > 0) {
                    var newText = currentText.slice(0, -1);
                    document.getElementById("username").innerHTML = newText;
                    setTimeout(eraseText, speed);
                } else {
                    i = 0;
                    setTimeout(typeWriter, speed);
                }
            }

            typeWriter();
        }

        animation();

    </script>

</body>

</html>
<?php

date_default_timezone_set("America/Sao_Paulo");

include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lab = $_POST["lab"];
    $professor = $_POST["professor"];
    $turma = $_POST["turma"];
    $data = $_POST["data"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];
    $atividade = $_POST["atividade"];

    if ($fim <= $inicio) {

        echo "<script>
            alert('O horário final deve ser maior que o inicial.');
        </script>";

    } else {

        $sql = "
            SELECT *
            FROM agendamentos
            WHERE laboratorio_id = '$lab'
            AND data = '$data'
            AND inicio < '$fim'
            AND fim > '$inicio'
        ";

        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {

            echo "<script>
                alert('Este laboratório já está ocupado neste horário.');
            </script>";

        } else {

            $sql = "
                INSERT INTO agendamentos
                (
                    laboratorio_id,
                    professor_id,
                    turma_id,
                    data,
                    inicio,
                    fim,
                    atividade
                )
                VALUES
                (
                    '$lab',
                    '$professor',
                    '$turma',
                    '$data',
                    '$inicio',
                    '$fim',
                    '$atividade'
                )
            ";

            $conexao->query($sql);

            echo "<script>
                alert('Agendamento realizado com sucesso!');
                window.location='index.php';
            </script>";

        }
    }
}

$labs = $conexao->query(
    "SELECT * FROM laboratorios"
);

$professores = $conexao->query(
    "SELECT * FROM professores ORDER BY nome"
);

$turmas = $conexao->query(
    "SELECT * FROM turmas ORDER BY nome"
);

$lab_selecionado = "";

if (isset($_GET["lab"])) {
    $lab_selecionado = $_GET["lab"];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Agendar Laboratório</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <h1>Controle de Laboratórios</h1>

    <nav>
        <a href="index.php">Início</a>
        <a href="agendar.php">Agendar</a>
    </nav>

</header>

<main>

    <div class="formulario">

        <h2>Agendar Laboratório</h2>

        <form method="POST">

            <label>Laboratório</label>

            <select name="lab" required>

                <option value="">
                    Selecione
                </option>

                <?php while ($item = $labs->fetch_assoc()): ?>

                    <option
                        value="<?php echo $item["id"]; ?>"
                        <?php
                        if ($lab_selecionado == $item["id"]) {
                            echo "selected";
                        }
                        ?>
                    >
                        <?php echo $item["nome"]; ?>
                    </option>

                <?php endwhile; ?>

            </select>


            <label>Professor</label>

            <select name="professor" required>

                <option value="">
                    Selecione
                </option>

                <?php while ($item = $professores->fetch_assoc()): ?>

                    <option value="<?php echo $item["id"]; ?>">
                        <?php echo $item["nome"]; ?>
                    </option>

                <?php endwhile; ?>

            </select>


            <label>Turma</label>

            <select name="turma" required>

                <option value="">
                    Selecione
                </option>

                <?php while ($item = $turmas->fetch_assoc()): ?>

                    <option value="<?php echo $item["id"]; ?>">
                        <?php echo $item["nome"]; ?>
                    </option>

                <?php endwhile; ?>

            </select>


            <label>Data</label>

            <input
                type="date"
                name="data"
                min="<?php echo date("Y-m-d"); ?>"
                required
            >


            <label>Horário inicial</label>

            <input
                type="time"
                name="inicio"
                required
            >


            <label>Horário final</label>

            <input
                type="time"
                name="fim"
                required
            >


            <label>Atividade</label>

            <input
                type="text"
                name="atividade"
                placeholder="Ex: Aula de informática"
                required
            >


            <button type="submit">
                Agendar
            </button>

        </form>

    </div>

</main>

</body>

</html>

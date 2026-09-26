<?php

date_default_timezone_set("America/Sao_Paulo");

include "conexao.php";

$data = date("Y-m-d");
$hora = date("H:i:s");

if (isset($_GET["excluir"])) {

    $id = $_GET["excluir"];

    $conexao->query(
        "DELETE FROM agendamentos WHERE id = $id"
    );

    header("Location: index.php");
    exit;
}

$labs = $conexao->query(
    "SELECT * FROM laboratorios"
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Controle de Laboratórios</title>

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

    <h2>Laboratórios</h2>

    <div class="labs">

        <?php while ($lab = $labs->fetch_assoc()): ?>

            <?php

            $id = $lab["id"];

            $sql = "
                SELECT
                    agendamentos.*,
                    professores.nome AS professor,
                    turmas.nome AS turma
                FROM agendamentos
                JOIN professores
                    ON professores.id = agendamentos.professor_id
                JOIN turmas
                    ON turmas.id = agendamentos.turma_id
                WHERE laboratorio_id = $id
                AND data = '$data'
                AND inicio <= '$hora'
                AND fim > '$hora'
            ";

            $resultado = $conexao->query($sql);

            ?>

            <div class="lab">

                <h3>
                    <?php echo $lab["nome"]; ?>
                </h3>

                <?php if ($resultado->num_rows > 0): ?>

                    <?php
                    $info = $resultado->fetch_assoc();
                    ?>

                    <p class="ocupado">
                         OCUPADO
                    </p>

                    <p>
                        Professor:
                        <?php echo $info["professor"]; ?>
                    </p>

                    <p>
                        Turma:
                        <?php echo $info["turma"]; ?>
                    </p>

                    <p>
                        <?php echo $info["inicio"]; ?>
                        -
                        <?php echo $info["fim"]; ?>
                    </p>

                <?php else: ?>

                    <p class="disponivel">
                         DISPONÍVEL
                    </p>

                <?php endif; ?>

                <a
                    class="botao"
                    href="agendar.php?lab=<?php echo $id; ?>"
                >
                    Agendar
                </a>

            </div>

        <?php endwhile; ?>

    </div>


    <h2>Agendamentos</h2>

    <div class="tabela">

        <table>

            <tr>

                <th>Laboratório</th>
                <th>Professor</th>
                <th>Turma</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Atividade</th>
                <th>Ação</th>

            </tr>

            <?php

            $lista = $conexao->query("

                SELECT
                    agendamentos.*,
                    laboratorios.nome AS laboratorio,
                    professores.nome AS professor,
                    turmas.nome AS turma

                FROM agendamentos

                JOIN laboratorios
                    ON laboratorios.id =
                       agendamentos.laboratorio_id

                JOIN professores
                    ON professores.id =
                       agendamentos.professor_id

                JOIN turmas
                    ON turmas.id =
                       agendamentos.turma_id

                ORDER BY data, inicio

            ");

            ?>

            <?php while ($item = $lista->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?php echo $item["laboratorio"]; ?>
                    </td>

                    <td>
                        <?php echo $item["professor"]; ?>
                    </td>

                    <td>
                        <?php echo $item["turma"]; ?>
                    </td>

                    <td>
                        <?php
                        echo date(
                            "d/m/Y",
                            strtotime($item["data"])
                        );
                        ?>
                    </td>

                    <td>
                        <?php echo $item["inicio"]; ?>
                        -
                        <?php echo $item["fim"]; ?>
                    </td>

                    <td>
                        <?php echo $item["atividade"]; ?>
                    </td>

                    <td>

                        <a
                            class="excluir"
                            href="index.php?excluir=<?php echo $item["id"]; ?>"
                            onclick="return confirm('Excluir este agendamento?')"
                        >
                            Excluir
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    </div>

</main>

</body>

</html>

<?php
require_once('reduzir.php');

$resolucoesDeTela = [2560, 1920, 1366, 1536, 1440, 1280, 390, 360, 412, 375, 414, 768, 820, 800];
//$resolucoesDeTela = [1920, 1366, 1280, 390, 360, 412, 375, 414, 768, 800];


sort($resolucoesDeTela);


function ImgP1($id_imagem, $largura, $altura, $qualidade = 50, $larguraBase = 1920, $outros = [])
{
    global $resolucoesDeTela;

    // prepara lista de resoluções
    $resols = array_values(array_unique($resolucoesDeTela));
    sort($resols, SORT_NUMERIC);

    $tamanhos = [];
    $mapTelas = [];
    $image_path = get_attached_file($id_imagem);
    $tagDeImagem = "<picture>\n";

    $seenWidths = [];

    foreach ($resols as $tela) {

        // preserva os valores originais
        $curLargura    = $largura;
        $curAltura     = $altura;
        $curBase       = $larguraBase;
        $curQualidade  = $qualidade;

        // redirecionamentos manuais (breakpoints fixos)
        if ($tela < 351) {
            $curLargura = 350;
            $curAltura  = 350;
            $curBase    = 350;
            $curQualidade = 80;
        } elseif ($tela < 401) {
            $curLargura = 400;
            $curAltura  = 250;
            $curBase    = 400;
            $curQualidade = 70;
        } elseif ($tela < 769) {
            $curLargura = 768;
            $curAltura  = 300;
            $curBase    = 768;
            $curQualidade = 70;
        }

        // proporção de largura
        $newWidth  = (int) round($tela * ($curLargura / $curBase));
        $newHeight = (int) round($curAltura * ($newWidth / $curLargura));

        // evita repetição
        if (!isset($seenWidths[$newWidth])) {
            $seenWidths[$newWidth] = true;
            $tamanhos[] = [
                'largura'   => $newWidth,
                'altura'    => $newHeight,
                'qualidade' => $curQualidade
            ];
            $mapTelas[] = $tela;
        }
    }

    // gera imagens
    $imagens = reduzirImagem($image_path, $tamanhos, 'jpg');

    if (empty($imagens['urls'])) {
        return '';
    }

    // monta sources
    $totalDeImagens = count($imagens['urls']) - 1;
    $linha = 0;

    foreach ($imagens['urls'] as $i) {
        $telaAtual = isset($mapTelas[$linha]) ? $mapTelas[$linha] : $resols[$linha];

        if ($linha === 0) {
            $maxnWi = $telaAtual;
            $controle = '<source media="(max-width: ' . $maxnWi . 'px)" srcset="' . $i . '">';
        } elseif ($linha === $totalDeImagens) {
            $minWi = $telaAtual;
            $resAnt = (isset($mapTelas[$linha - 1]) ? $mapTelas[$linha - 1] : $resols[$linha - 1]) + 1;
            $tagDeImagem .= '<source media="(min-width: ' . $resAnt . 'px) and (max-width: ' . ($minWi - 1) . 'px)" srcset="' . $i . '">' . "\n";
            $controle = '<source media="(min-width: ' . $minWi . 'px)" srcset="' . $i . '">';
        } else {
            $resAnterior = (isset($mapTelas[$linha - 1]) ? $mapTelas[$linha - 1] : $resols[$linha - 1]) + 1;
            $controle = '<source media="(min-width: ' . $resAnterior . 'px) and (max-width: ' . $telaAtual . 'px)" srcset="' . $i . '">';
        }

        $tagDeImagem .= $controle . "\n";
        $linha++;
    }

    // fallback
    $fallback = end($imagens['urls']);

    $atributosExtras = '';
    foreach ($outros as $attr => $valor) {
        $atributosExtras .= ' ' . $attr . '="' . htmlspecialchars($valor, ENT_QUOTES) . '"';
    }

    $tagDeImagem .= '<img class="modelo lazy-loaded" src="' . $fallback . '"' . $atributosExtras . '>' . "\n";
    $tagDeImagem .= "</picture>";

    return $tagDeImagem;
}

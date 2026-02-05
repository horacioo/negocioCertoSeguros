<?php

function reduzirImagem($caminhoImagem, $tamanhos, $extensao = 'avif') {
    // Verifica se o arquivo existe
    if (!file_exists($caminhoImagem)) {
        return "Erro: Imagem não encontrada no caminho especificado.";
    }

    // Obtém informações da imagem
    $infoImagem = getimagesize($caminhoImagem);
    if ($infoImagem === false) {
        return "Erro: Não foi possível obter informações da imagem.";
    }

    list($larguraOriginal, $alturaOriginal, $tipoImagem) = $infoImagem;

    // Cria a imagem de acordo com o tipo
    switch ($tipoImagem) {
        case IMAGETYPE_JPEG:
            $imagem = imagecreatefromjpeg($caminhoImagem);
            break;
        case IMAGETYPE_PNG:
            $imagem = imagecreatefrompng($caminhoImagem);
            break;
        case IMAGETYPE_GIF:
            $imagem = imagecreatefromgif($caminhoImagem);
            break;
        default:
            return "Erro: Tipo de imagem não suportado.";
    }

    $resultados = [];
    $urlsImagens = []; // Array para armazenar as URLs das imagens geradas

    // Obtém a URL e o caminho base dos uploads do WordPress
    $uploads = wp_upload_dir();
    $urlBase = $uploads['baseurl'] . '/'; // URL base dos uploads

    // Extrai as pastas de data do caminho da imagem original
    $caminhoRelativo = str_replace($uploads['basedir'], '', $caminhoImagem); // Obtém o caminho relativo
    $pastaData = dirname($caminhoRelativo); // Pega a pasta de data do caminho
    $pastaSalvar = dirname($caminhoImagem) . DIRECTORY_SEPARATOR . 'reduzidas'; // Pasta para salvar as imagens

    // Verifica se a pasta 'reduzidas' existe e cria se necessário
    if (!is_dir($pastaSalvar)) {
        if (!mkdir($pastaSalvar, 0777, true)) {
            return "Erro: Não foi possível criar a pasta 'reduzidas'.";
        }
        chmod($pastaSalvar, 0777); // Garante que a pasta seja gravável
    }

    // Verifica se o diretório é gravável
    if (!is_writable($pastaSalvar)) {
        return "Erro: O diretório não é gravável.";
    }

    foreach ($tamanhos as $tamanho) {
        $largura = $tamanho['largura'];
        $altura = $tamanho['altura'];
        $qualidade = $tamanho['qualidade'];

        // Mantém o ratio se um dos valores for 0
        if ($largura == 0 && $altura == 0) {
            continue; // Nenhuma alteração se ambos forem 0
        } elseif ($largura == 0) {
            // Mantém a proporção com a altura
            $largura = ($altura / $alturaOriginal) * $larguraOriginal;
        } elseif ($altura == 0) {
            // Mantém a proporção com a largura
            $altura = ($largura / $larguraOriginal) * $alturaOriginal;
        }

        // Define o nome para salvar a imagem, no formato especificado
        $nomeImagemOriginal = basename($caminhoImagem);
        $nomeSemExtensao = pathinfo($nomeImagemOriginal, PATHINFO_FILENAME);
        $caminhoSalvar = $pastaSalvar . DIRECTORY_SEPARATOR . "qualidade{$qualidade}_{$nomeSemExtensao}_wallpapers_{$largura}X{$altura}.$extensao";

        // Verifica se a imagem já foi salva
        if (file_exists($caminhoSalvar)) {
            $resultados[] = "Imagem já existe: " . $caminhoSalvar;
            $urlsImagens["{$largura}x{$altura}"] = $urlBase . $pastaData . '/reduzidas/' . "qualidade{$qualidade}_{$nomeSemExtensao}_wallpapers_{$largura}X{$altura}.$extensao"; // Adiciona a URL ao array
            continue; // Pula para o próximo tamanho
        }

        // Calcula a nova largura e altura
        $ratioOriginal = $larguraOriginal / $alturaOriginal;
        $ratioNovo = $largura / $altura;

        if ($ratioOriginal > $ratioNovo) {
            // A imagem é mais larga que o novo tamanho
            $novaAltura = $altura;
            $novaLargura = $altura * $ratioOriginal;
        } else {
            // A imagem é mais alta que o novo tamanho
            $novaLargura = $largura;
            $novaAltura = $largura / $ratioOriginal;
        }

        // Cria a nova imagem redimensionada
        $imagemRedimensionada = imagecreatetruecolor($novaLargura, $novaAltura);
        if ($tipoImagem == IMAGETYPE_PNG || $tipoImagem == IMAGETYPE_GIF) {
            imagecolortransparent($imagemRedimensionada, imagecolorallocatealpha($imagemRedimensionada, 0, 0, 0, 127));
            imagealphablending($imagemRedimensionada, false);
            imagesavealpha($imagemRedimensionada, true);
        }

        // Redimensiona a imagem original
        imagecopyresampled($imagemRedimensionada, $imagem, 0, 0, 0, 0, $novaLargura, $novaAltura, $larguraOriginal, $alturaOriginal);

        // Calcula as coordenadas do corte central
        $xOffset = ($novaLargura - $largura) / 2;
        $yOffset = ($novaAltura - $altura) / 2;

        // Cria a imagem final cortada
        $imagemFinal = imagecreatetruecolor($largura, $altura);
        if ($tipoImagem == IMAGETYPE_PNG || $tipoImagem == IMAGETYPE_GIF) {
            imagecolortransparent($imagemFinal, imagecolorallocatealpha($imagemFinal, 0, 0, 0, 127));
            imagealphablending($imagemFinal, false);
            imagesavealpha($imagemFinal, true);
        }

        // Copia a parte central da imagem redimensionada para a imagem final
        imagecopyresampled($imagemFinal, $imagemRedimensionada, 0, 0, $xOffset, $yOffset, $largura, $altura, $largura, $altura);

        // Verifica se o PHP tem suporte para AVIF
        if (!function_exists('imageavif') && $extensao === 'avif') {
            return "Erro: Suporte para AVIF não disponível no servidor.";
        }

        // Tenta salvar a imagem no formato correto
        $salvouComSucesso = false;
        if ($extensao === 'avif' && function_exists('imageavif')) {
            $salvouComSucesso = imageavif($imagemFinal, $caminhoSalvar, $qualidade);
        } elseif ($extensao === 'png') {
            $salvouComSucesso = imagepng($imagemFinal, $caminhoSalvar);
        } elseif ($extensao === 'jpeg' || $extensao === 'jpg') {
            $salvouComSucesso = imagejpeg($imagemFinal, $caminhoSalvar, $qualidade);
        }

        if (!$salvouComSucesso) {
            return "Erro: Não foi possível salvar a imagem em {$caminhoSalvar}.";
        }

        $resultados[] = "Imagem salva com sucesso em: " . $caminhoSalvar;
        $urlsImagens["{$largura}x{$altura}"] = $urlBase . $pastaData . '/reduzidas/' . "qualidade{$qualidade}_{$nomeSemExtensao}_wallpapers_{$largura}X{$altura}.$extensao"; // Adiciona a URL ao array

        // Libera memória
        imagedestroy($imagemRedimensionada);
        imagedestroy($imagemFinal);
    }

    // Libera memória da imagem original
    imagedestroy($imagem);

    return [
        'resultados' => $resultados,
        'urls' => $urlsImagens // Retorna as URLs das imagens organizadas
    ];
}


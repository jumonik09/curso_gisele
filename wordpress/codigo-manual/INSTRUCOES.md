# Trilha da Aquarela no WordPress

Crie uma página com o slug `curso-de-aquarela` e use o layout de largura total do Astra. Nas configurações da página, desative o título do tema, pois o HTML já traz o título. Use o cabeçalho e o rodapé do site.

## Arquivo único

Cole todo o conteúdo de `curso-completo-wordpress.html` em um único bloco HTML personalizado. Essa opção depende de o usuário do WordPress poder salvar as tags `<style>` e `<script>`. Confira se elas foram preservadas após salvar. Use uma das duas formas de instalação manual.

## Arquivos separados

- **HTML:** cole `curso.html` em um bloco HTML personalizado.
- **CSS:** cole `curso.css` no CSS adicional do tema.
- **JavaScript:** carregue `curso.js` no rodapé pelo mecanismo de código personalizado disponível na instalação. Se o campo espera HTML, envolva o conteúdo em `<script>` e `</script>`. O script só atua dentro da landing page.
- **Menu:** adicione a página publicada ou o link `https://gisellevargas.com.br/curso-de-aquarela/` aos menus usados no desktop e no celular.
- **Prévia:** quando o vídeo estiver disponível, envie o MP4 à Biblioteca de mídia e adicione `data-source="URL_DO_MP4"` à tag `<video>` no HTML.

## Imagens

No gerenciador de arquivos da hospedagem, copie os seguintes arquivos de `../trilha-da-aquarela/assets/` para `wp-content/uploads/trilha-da-aquarela/`:

- `aquarela.jpg`
- `aquarela-passaro.jpg`
- `giselle.jpg`
- `faixa-roxa.png`
- `pincelada-terracota.png`

Se você usar a Biblioteca de mídia e ela gerar outros endereços, atualize os URLs correspondentes no HTML e no CSS. Na instalação via plugin, as imagens já vêm no ZIP.

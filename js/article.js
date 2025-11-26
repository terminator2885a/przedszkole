import MarkdownIt from "https://esm.sh/markdown-it@13";
import TurndownService from 'https://esm.sh/turndown@7.1.2';

function generateArticle(){
    const articleContent = document.querySelector('#article-content');
    const articlePreview = document.querySelector('#article-preview');
    const hiddenTextarea = document.querySelector('#hidden-article-preview');

    const md = new MarkdownIt();

    articlePreview.innerHTML = md.render(articleContent.value);
    hiddenTextarea.innerHTML = md.render(articleContent.value);
}

generateArticle();

document.querySelector('#article-show-preview').addEventListener('click', generateArticle);
document.querySelector('#save-changes').addEventListener('click', generateArticle);

function htmlToMd() {
  const articleContent = document.querySelector('#article-content');
  const content = articleContent.value;

  if (content.includes('<')) {
    const turndown = new TurndownService();
    const markdown = turndown.turndown(content);
    articleContent.value = markdown;
  }

  generateArticle();
}
htmlToMd();
import MarkdownIt from "https://esm.sh/markdown-it@13";

function generateMessage(){
  const messageContent = document.querySelector('#message');
  const md = new MarkdownIt();

  console.log(messageContent.value);
  messageContent.value = md.render(messageContent.value.replace(/\r?\n/g, "\n\n"));

}

document.querySelector('#send-message').addEventListener('click', generateMessage);
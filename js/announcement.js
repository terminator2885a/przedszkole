import MarkdownIt from "https://esm.sh/markdown-it@13";

function generaterAnnouncement(){
    console.log('Start');
    
    const announcementContent = document.querySelector('#tresc_komunikatu');

    const md = new MarkdownIt();

    announcementContent.value = md.render(announcementContent.value);
}

document.querySelector('#add_announcement').addEventListener('click', generaterAnnouncement);
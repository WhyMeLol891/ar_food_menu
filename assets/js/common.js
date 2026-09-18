const targetProgress=document.getElementById('progress');if(targetProgress){
	fetch('api/target.php?ts='+Date.now()).then(response=>response.json()).then(result=>{
		if(result.installed){targetProgress.textContent='Target file: installed and ready.';targetProgress.dataset.installed='1';}
	}).catch(()=>{});}
async function loadLayout() { const response = await fetch('assets/targets/layout.json?ts=' + Date.now()); return response.json(); }
window.loadLayout=loadLayout;
function esc(value) { return String(value).replace(/[&<>\"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;',"'":'&#039;'}[char])); }

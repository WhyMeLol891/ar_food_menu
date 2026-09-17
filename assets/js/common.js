async function loadLayout() { const response = await fetch('assets/targets/layout.json?ts=' + Date.now()); return response.json(); }
function esc(value) { return String(value).replace(/[&<>\"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;',"'":'&#039;'}[char])); }

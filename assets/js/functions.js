function cerrar_pop(){
    var cerrar_pop = document.getElementById('pop')
    cerrar_pop.style.left = "300vh"
}

function abrir_pop(){
    var abrir_pop = document.getElementById('pop')
    abrir_pop.style.left = "0"
}

const diaSelect = document.getElementById('dia');
const mesSelect = document.getElementById('mes');
const anioInput = document.getElementById('anio');
    
const hoy = new Date();
const anioActual = hoy.getFullYear();
anioInput.value = anioActual;
function poblarDias(mes, anio) {
    const diasEnMes = new Date(anio, mes, 0).getDate();
    diaSelect.innerHTML = '';
    
    for (let i = 1; i <= diasEnMes; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        diaSelect.appendChild(option);
    }
}
const mesActual = hoy.getMonth() + 1;
mesSelect.selectedIndex = mesActual;
poblarDias(mesActual, anioActual);
diaSelect.value = hoy.getDate();
    
mesSelect.addEventListener('change', () => {
    const mesSeleccionado = mesSelect.selectedIndex;
    if (mesSeleccionado > 0) {
        poblarDias(mesSeleccionado, anioActual);
    }
});


            
            
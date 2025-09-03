document.addEventListener('DOMContentLoaded', function () {
    const tipoSelector = document.getElementById('tipo-usuario-selector');
    const usuariosLista = document.getElementById('usuarios-lista');
    const usuariosCards = document.getElementById('usuarios-cards');
    const voltarBtn = document.getElementById('voltar-tipos');

    const imagens = {
        3: '../assets/img/admin.svg',
        2: '../assets/img/professor.svg',
        1: '../assets/img/aluno.svg',
        0: '../assets/img/visitante.svg'
    };

    document.querySelectorAll('.card-select').forEach(card => {
        card.addEventListener('click', function () {
            const tipo = this.getAttribute('data-tipo');
            mostrarUsuarios(tipo);
        });
    });

    voltarBtn.addEventListener('click', function () {
        usuariosLista.style.display = 'none';
        tipoSelector.style.display = '';
        usuariosCards.innerHTML = '';
    });

    function mostrarUsuarios(tipo) {
        tipoSelector.style.display = 'none';
        usuariosLista.style.display = '';
        usuariosCards.innerHTML = '';

        const usuarios = usuariosPorTipo[tipo] || [];
        if (usuarios.length === 0) {
            usuariosCards.innerHTML = '<p>Nenhum usuário encontrado.</p>';
            return;
        }

        usuarios.forEach(u => {
            const card = document.createElement('div');
            card.className = 'col-md-4 usuario-card';

            // Use a foto real se houver, senão imagem padrão
            let foto = imagens[tipo];
            // Se você tiver campo de foto, troque aqui:
            // if (u.fotousuario) foto = u.fotousuario;

            card.innerHTML = `
                <img src="${foto}" class="usuario-foto" alt="Foto de ${u.nomeusuario}">
                <h5>${u.nomeusuario}</h5>
                <p>${u.emailusuario}</p>
                <div>
                    <a href="editarusuario.php?id=${encodeURIComponent(u.idusuario)}" class="btn btn-sm btn-primary">Editar</a>
                    <a href="excluirusuario.php?id=${encodeURIComponent(u.idusuario)}" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </div>
            `;
            usuariosCards.appendChild(card);
        });
    }

    const modal = document.getElementById('pendentesModal');
    const btn = document.getElementById('mostrarPendentes');
    const span = document.getElementsByClassName('close')[0];

    if (btn) {
        btn.onclick = function () {
            modal.style.display = "block";
        }
    }

    if (span) {
        span.onclick = function () {
            modal.style.display = "none";
        }
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
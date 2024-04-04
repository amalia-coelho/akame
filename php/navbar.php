<nav>
    <div class="mobile-menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
    <div class="logo">
        <a href="index.php"><img src="img/logo.png " alt="logo"></a>
    </div>
    <ul class="nav-list">
        <li><a href="index.php">Início</a></li>
        <li><a href="catalogo.php">Catálogo</a></li>
        <?php
            if(isset($_SESSION['id']) && $_SESSION['nivel'] == 1){?>
                <li><a href="gestao_loja.php">Produtos</a></li>
                <li><a href="gestao_categ.php"> Categorias</a></li>
                <li><a href="users.php">Users</a></li>
        <?php    
            }else if(isset($_SESSION['id']) && $_SESSION['nivel'] != 1){?>
                <li><a href="catalogo.php">Início</a></li>
                <li><a href="carrinho.php">Carrinho</a></li>
        <?php
            }

            if(isset($_SESSION['id'])){?>
                <li><a class="cadastro" href="logout.php">Sair</a></li>
        <?php
            }else{?>
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
        <?php
            }
        ?>
    </ul>
</nav>

<script>
class MobileNavbar {
    constructor(mobileMenu, navList, navLinks) {
        this.mobileMenu = document.querySelector(mobileMenu);
        this.navList = document.querySelector(navList);
        this.navLinks = document.querySelectorAll(navLinks);
        this.activeClass = "active";

        this.handleClick = this.handleClick.bind(this);
    }

    animateLinks() {
        this.navLinks.forEach((link, index) => {
          link.style.animation ? (link.style.animation = "") : (link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`);
        });
    }

    handleClick() {
        this.navList.classList.toggle(this.activeClass);
        this.mobileMenu.classList.toggle(this.activeClass);
        this.animateLinks();
    }

    addClickEvent() {
        this.mobileMenu.addEventListener("click", this.handleClick);
    }

    init() {
        if (this.mobileMenu) {
            this.addClickEvent();
        }
        return this;
        }
    }

    const mobileNavbar = new MobileNavbar(
        ".mobile-menu",
        ".nav-list",
        ".nav-list li",
    );
    mobileNavbar.init();
</script>

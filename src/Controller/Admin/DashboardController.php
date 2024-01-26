<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Consigne;
use App\Entity\PretClef;
use Symfony\Bundle\SecurityBundle\Security;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

    /**
     * @Security("is_granted('ROLE_USER') and is_granted('ROLE_EDITOR') and is_granted('ROLE_ADMIN') and is_granted('ROLE_DEV')")
     */
class DashboardController extends AbstractDashboardController
{
    #[Route('/twvadmin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('http//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')
        ->addCssFile('css/admin2.css');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            // you can include HTML contents too (e.g. to link to an image)
            ->setTitle('<img src="https://media.discordapp.net/attachments/1168248292581326949/1198406208718118942/TWV_logo_JAUNE-BLANC-flat.png?ex=65bec9c1&is=65ac54c1&hm=5eee3771f51624d472b4109b5720a4c3210268d85057a98dfe9cbf77bbc7d1b8&=&format=webp&quality=lossless">')
            
            // by default EasyAdmin displays a black square as its default favicon;
            // use this method to display a custom favicon: the given path is passed
            // "as is" to the Twig asset() function:
            // <link rel="shortcut icon" href="{{ asset('...') }}">
            ->setFaviconPath('favicon.svg')

            // the domain used by default is 'messages'
           
        ;
    }

    
 

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            // ->setName($user->getName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            ->setAvatarUrl('https://media.discordapp.net/attachments/1168248292581326949/1198406208718118942/TWV_logo_JAUNE-BLANC-flat.png?ex=65bec9c1&is=65ac54c1&hm=5eee3771f51624d472b4109b5720a4c3210268d85057a98dfe9cbf77bbc7d1b8&=&format=webp&quality=lossless')

            // use this method if you don't want to display the user image
            ->displayUserAvatar(true)
            // you can also pass an email address to use gravatar's service

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linktoRoute('Retour au site', 'fas fa-rotate-left', 'home'),

            MenuItem::section('Gestion Park'),
            MenuItem::linkToCrud('Prêt de Clef', 'fa fa-key', PretClef::class),
            MenuItem::linkToCrud('Consignes', 'fa fa-clipboard', Consigne::class),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
        ];
    }
}

import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Injectable({ providedIn: 'root' })
export class AuthGuard implements CanActivate {
    constructor(
        private router: Router,
        private authService: AuthService
    ) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        if (this.authService.isAuthenticated()) {
            // autorizado, então retorna true
            return true;
        }

        // não está logado, então redireciona para a página de login com a URL de retorno
        this.router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
        return false;
    }
}
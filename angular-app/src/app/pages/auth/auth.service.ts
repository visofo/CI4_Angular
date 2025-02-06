import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from '../../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class AuthService {
    private apiUrl = environment.apiUrl; // URL do backend
    private currentUserSubject: BehaviorSubject<any>;
    public currentUser: Observable<any>;

    constructor(private http: HttpClient) {
        this.currentUserSubject = new BehaviorSubject<any>(JSON.parse(localStorage.getItem('currentUser') || '{}'));
        this.currentUser = this.currentUserSubject.asObservable();
    }

    public get currentUserValue(): any {
        return this.currentUserSubject.value;
    }

    login(email: string, senha: string): Observable<any> {
        return this.http.post<any>(`${this.apiUrl}login`, { email: email, senha: senha })
            .pipe(map(response => {
                // login bem-sucedido se houver um token jwt na resposta
                if (response && response.token) {
                    // armazena os detalhes do usuário e o token jwt no armazenamento local para manter o usuário logado entre as atualizações da página
                    localStorage.setItem('currentUser', JSON.stringify(response));
                    this.currentUserSubject.next(response);
                }

                return response;
            }));
    }

    logout() {
        // remove o usuário do armazenamento local para fazer o logout do usuário
        localStorage.removeItem('currentUser');
        this.currentUserSubject.next(null);
    }

    register(nome: string, email: string, senha: string): Observable<any> {
        return this.http.post<any>(`${this.apiUrl}register`, { nome: nome, email: email, senha: senha });
    }

    getToken(): string | null {
        const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');
        return currentUser ? currentUser.token : null;
    }

    isAuthenticated(): boolean {
        return !!this.getToken();
    }
}
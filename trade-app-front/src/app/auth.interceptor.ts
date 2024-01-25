import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent,
} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    // Obter o token do localStorage

    if (typeof window !== 'undefined') {
      // Acesse o localStorage aqui
      const token = localStorage.getItem('token');

      // Clonar a requisição e adicionar o token no cabeçalho 'Authorization'
      if (token) {
        request = request.clone({
          setHeaders: {
            Authorization: `Bearer ${token}`,
          },
        });
      }
    }

    // Continuar com a requisição modificada
    return next.handle(request);
  }
}

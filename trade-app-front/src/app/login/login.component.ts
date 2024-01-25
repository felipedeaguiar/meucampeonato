import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {HttpClient} from "@angular/common/http";
import { BsModalService, BsModalRef } from 'ngx-bootstrap/modal';
import {ErroComponent} from "../erro/erro.component";
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    ReactiveFormsModule
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent  implements OnInit{

  loginForm: FormGroup = this.fb.group({
    email: ['', Validators.required],
    password: ['', Validators.required]
  });

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private bsModalService: BsModalService,
    private bsModalRef: BsModalRef,
    private router: Router
  ) {}

  ngOnInit(): void {}

  onSubmit()
  {
    if (this.loginForm.valid) {
      this.http.post<any>('http://localhost/api/login/',this.loginForm.value)
        .subscribe((resultado) => {
          localStorage.setItem('token', resultado.token);
          localStorage.setItem('user', resultado.user);

          this.router.navigate(['campeonato'])

        },(resultado) => {
          this.mostraModalErro(resultado.error.message);
        });
    }
  }

  mostraModalErro(erro: string)
  {
    const initialState = {
      mensagemErro: erro
    };

    this.bsModalRef = this.bsModalService.show(ErroComponent, {initialState} as any);
  }
}

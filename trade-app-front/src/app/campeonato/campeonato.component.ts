import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { BsModalService, BsModalRef } from 'ngx-bootstrap/modal';
import { ErroComponent } from '../erro/erro.component';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-campeonato',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule,RouterModule],
  templateUrl: './campeonato.component.html',
  styleUrl: './campeonato.component.css'
})
export class CampeonatoComponent {

  campeonatos: any[] = [];
  times: any[] = [];
  formularioCampeonato!: FormGroup;
  formularioTime!: FormGroup;

  constructor(
    private http: HttpClient,
    private formBuilder: FormBuilder,
    private bsModalService: BsModalService,
    private bsModalRef: BsModalRef
  ) {}

  ngOnInit() {
    this.getCampeonatos();
    this.getTimes();

    this.formularioCampeonato = this.formBuilder.group({
      nome: ['', Validators.required]
    });

    this.formularioTime = this.formBuilder.group({
      nome: ['', Validators.required]
    });
  }

  protected getCampeonatos()
  {
    this.http.get<any>('http://localhost/api/campeonato').subscribe(resultado => {
        this.campeonatos = resultado.data;
    });
  }

  protected getTimes()
  {
    this.http.get<any>('http://localhost/api/time').subscribe(resultado => {
        this.times = resultado.data;
    });
  }

  submitForm() {
    if (this.formularioCampeonato.valid) {
      this.http.post<any>('http://localhost/api/campeonato', this.formularioCampeonato.value).subscribe(resultado => {
        this.campeonatos.push(resultado.data);
        this.formularioCampeonato.reset();
      });
    }
  }

  submitFormTime() {
    if (this.formularioTime.valid) {
      this.http.post<any>('http://localhost/api/time', this.formularioTime.value).subscribe(resultado => {
        this.times.push(resultado.data);
        this.formularioTime.reset();
      });
    }
  }


  iniciar(id: number) {
   this.http.post<any>('http://localhost/api/campeonato/'+id+'/iniciar',{})
      .subscribe(
        (resultado) => {
        console.log(resultado);
      },(resultado) => {
          this.mostraModalErro(resultado.error.erro);
      });
  }

  mostraModalErro(erro: string)
  {
    const initialState = {
      mensagemErro: erro
    };

    this.bsModalRef = this.bsModalService.show(ErroComponent, {initialState} as any);
  }
}

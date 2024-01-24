import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import {ActivatedRoute, RouterLink} from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-campeonato-detalhe',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './campeonato-detalhe.component.html',
  styleUrl: './campeonato-detalhe.component.css'
})
export class CampeonatoDetalheComponent {
  id: string | null = null;
  idFase: string | null = null;

  campeonato: any;
  faseAtual: any;
  partidas: any;

  constructor(
    private route: ActivatedRoute,
    private http: HttpClient,
  ){}

  ngOnInit() {
    this.route.paramMap.subscribe(params => {
      const idParam = params.get('id');
      const idFase = params.get('idFase');

      this.id = idParam !== null ? idParam : null;
      this.idFase = idFase !== null ? idFase : null;

      this.getPartidas();
    });
  }

  public getCampeonato()
  {
    this.http.get<any>('http://localhost/api/campeonato/'+this.id).subscribe(resultado => {
        this.campeonato = resultado.data;
    });
  }

  public getPartidas()
  {
    this.http.get<any>('http://localhost/api/campeonato/'+this.id+'/partidas/'+this.idFase).subscribe(resultado => {
      if (resultado.data.length === 0) {
          this.chavear();
      } else {
        this.campeonato = resultado.data.campeonato;
        this.partidas = resultado.data.partidas;
      }
    });
  }

  public getFaseAtual()
  {
    this.http.get<any>('http://localhost/api/campeonato/'+this.id+'/fase-atual').subscribe(resultado => {
        this.faseAtual = resultado.data;
    });
  }

  public chavear() {
    this.http.post<any>('http://localhost/api/campeonato/'+this.id+'/chavear/', {}).subscribe(resultado => {
        this.partidas = resultado.data;
    });
  }

  public simular() {
    this.http.post<any>('http://localhost/api/campeonato/'+this.id+'/simular', {}).subscribe(resultado => {
      this.getPartidas();
    });
  }
}

import { Routes } from '@angular/router';
import { CampeonatoDetalheComponent } from './campeonato-detalhe/campeonato-detalhe.component';
import { CampeonatoComponent } from './campeonato/campeonato.component';

export const routes: Routes = [
    { path: '', component: CampeonatoComponent},
    { path: 'campeonato/:id/fase/:idFase', component: CampeonatoDetalheComponent },
];

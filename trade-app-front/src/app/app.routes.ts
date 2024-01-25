import { Routes } from '@angular/router';
import { CampeonatoDetalheComponent } from './campeonato-detalhe/campeonato-detalhe.component';
import { CampeonatoComponent } from './campeonato/campeonato.component';
import {LoginComponent} from "./login/login.component";

export const routes: Routes = [
    { path: 'campeonato', component: CampeonatoComponent},
    { path: 'login', component: LoginComponent},
    { path: 'campeonato/:id/fase/:idFase', component: CampeonatoDetalheComponent },
];

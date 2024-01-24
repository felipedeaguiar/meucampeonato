import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { CampeonatoComponent } from './campeonato/campeonato.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, CampeonatoComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'Meu Campeonato';
}

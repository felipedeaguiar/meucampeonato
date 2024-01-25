import { Component, Input } from '@angular/core';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';

@Component({
  selector: 'app-erro',
  standalone: true,
  imports: [],
  templateUrl: './erro.component.html',
  styleUrl: './erro.component.css'
})
export class ErroComponent {

  @Input() mensagemErro: string = '';


  constructor() { }

  fecharModal() {

  }
}

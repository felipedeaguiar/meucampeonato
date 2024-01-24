import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CampeonatoDetalheComponent } from './campeonato-detalhe.component';

describe('CampeonatoDetalheComponent', () => {
  let component: CampeonatoDetalheComponent;
  let fixture: ComponentFixture<CampeonatoDetalheComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CampeonatoDetalheComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CampeonatoDetalheComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

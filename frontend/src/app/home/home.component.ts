import { Component, OnInit, ViewChild } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { GasService } from '../services/gas.service';
import { MatSort, MatTableDataSource } from '@angular/material';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})

export class HomeComponent implements OnInit {

  @ViewChild(MatSort, {static: true}) sort: MatSort;

  form: FormGroup;
  states: any;
  municipalities: any;
  displayedColumns: string[] = ['state', 'city', 'municipality', 'settling', 'zp'];
  dataSource = null;

  constructor(
    private fb: FormBuilder,
    private _gasService: GasService
  ) { }

  ngOnInit(): void {
    this.createForm();
    this.getStates();
  }

  createForm() {
    this.form = this.fb.group({
      state: ['', [Validators.required]],
      municipality: ['', [Validators.required]]
    });
  }

  getStates() {
    this._gasService.getStates().then(res => {
      this.states = res.data;
    });
  }

  getMunicipalities($event) {
    this.municipalities = null;
    this._gasService.getMunicipalities($event.value).then(res => {
      this.municipalities = res.data;
    });
  }

  getZipCodes() {
    let state = this.state.value;
    let municipality = this.municipality.value;
    this._gasService.getZipCodes(state, municipality).then(res => {
      this.dataSource = new MatTableDataSource(res.data);
      this.dataSource.sort = this.sort;
    });
  }

  /**
   * Get state
   */
  get state() {
    return this.form.get('state');
  }


  /**
   * Get municipality
   */
  get municipality() {
    return this.form.get('municipality');
  }

}

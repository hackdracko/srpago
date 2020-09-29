import { Component, OnInit, ViewChild } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { GasService } from '../services/gas.service';
import { MatSort, MatTableDataSource } from '@angular/material';
import { MouseEvent } from '@agm/core';

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
  showMap = false;
  title = 'Sin información';
  street = '';

  // google maps zoom level
  zoom: number = 11;

  // initial center position for the map
  lat: number = 19.39068;
  lng: number = -99.2836988;

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
      if(res.data.length > 0) {
        this.markers = [];
        this.dataSource = new MatTableDataSource(res.data);
        this.dataSource.sort = this.sort;
        this.title = res.data[0].razonsocial;
        this.street = res.data[0].calle;
        this.zoom = 17;
        this.lat = parseFloat(res.data[0].latitude);
        this.lng = parseFloat(res.data[0].longitude);
        let newMarker = 	  {
          lat: this.lat,
          lng: this.lng,
          label: 'A',
          draggable: false
        };
        this.markers.push(newMarker);
        this.showMap = true;
      } else {
        alert('No hay información con esa busqueda');
      }
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

  clickedMarker(label: string, index: number) {
    console.log(`clicked the marker: ${label || index}`)
  }
  
  markers = [
	  {
		  lat: this.lat,
		  lng: this.lng,
		  label: 'A',
		  draggable: false
	  }
  ]

}

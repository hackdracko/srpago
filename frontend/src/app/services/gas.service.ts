import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable()
export class GasService {
  private url = environment.SERVER_URL;
  constructor(
    private _http: HttpClient
  ) { }

  public getStates() {
    return this._http.get<any>(this.url + 'states').toPromise();
  }

  public getMunicipalities(state: string) {
    return this._http.get<any>(this.url + 'municipalities/' + state).toPromise();
  }

  public getZipCodes(state: string, municipality: string) {
    return this._http.get<any>(this.url + 'zip-codes/' + state + '/' + municipality).toPromise();
  }
}
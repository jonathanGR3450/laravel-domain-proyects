import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from '../pages/interfaces/user.interface';


@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private url: string = 'http://127.0.0.1:80/api';

  constructor(private http: HttpClient) { }

  signin(user: User): Observable<any> {
    return this.http.post<any>(`${this.url}/login`, user);
  }

  // Access user profile
  profileUser(): Observable<any> {
    return this.http.post(`${this.url}/user`, {});
  }
}

import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Resp } from '../interfaces/resp.interface';
import { RespBlog } from '../interfaces/respblog.interface';
import { Blog } from '../interfaces/blog.interface';

@Injectable({
  providedIn: 'root'
})
export class BlogService {

  private url: string = 'http://127.0.0.1:80/api';

  constructor(private http: HttpClient) { }

  getBlogs() {
    return this.http.get<Resp>(`${this.url}/blogs`);
  }

  getBlogsByUser(userId: string) {
    const params = new HttpParams().set('user_id', userId)
    return this.http.get<Resp>(`${this.url}/blogs`, { params });
  }

  saveBlog(blog: any) {
    return this.http.post<Resp>(`${this.url}/blogs`, blog);
  }

  addBlog(personaje: any) {
    return this.http.post(`${this.url}/blogs`, personaje);
  }

  deleteBlog(id: string) {
    return this.http.delete(`${this.url}/blogs/${id}`)
  }

  getBlog(id: string) {
    return this.http.get<RespBlog>(`${this.url}/blogs/${id}`)
  }

  updateBlog(id: string, blog: Blog) {
    return this.http.put(`${this.url}/blogs/${id}`, blog)
  }
}

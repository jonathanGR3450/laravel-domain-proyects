import { Component } from '@angular/core';
import { BlogService } from '../services/blog.service';
import { Blog } from '../interfaces/blog.interface';
import { Resp } from '../interfaces/resp.interface';
import { AuthService } from 'src/app/shared/auth.service';
import { User } from '../interfaces/user.interface';
import { RespUser } from '../interfaces/respuser.interface';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { RespBlog } from '../interfaces/respblog.interface';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent {

  blogs!: Blog[];
  user: User = {
    name: '',
    last_name: '',
    email: ''
  };

  blog: Blog = {
    id: '',
    name: '',
    description: '',
    user_id: '',
    created_at: '',
    updated_at: '',
  }

  id!: string;

  form: FormGroup = this.fb.group({
    name: [, [
      Validators.required,
      Validators.minLength(2)
    ]],
    description: [, [
      Validators.required,
      Validators.minLength(2)
    ]]
  });

  formUpdate: FormGroup = this.fb.group(
    {
      name: [, [
        Validators.required,
        Validators.minLength(2)
      ]],
      description: [, [
        Validators.required,
        Validators.minLength(2)
      ]]
    }
  );


  constructor(public authService: AuthService, private blogService: BlogService, private fb: FormBuilder) {
    this.getAuthUser();
  }

  getAuthUser() {
    this.authService.profileUser().subscribe((respUser: RespUser) => {
      this.user = respUser.data;
      this.getBlogs()
    });
  }

  getBlogs() {
    this.blogService.getBlogsByUser(this.user.id || '').subscribe((resp: Resp) => {
      this.blogs = resp.data
      console.log(this.blogs);

    });
  }

  getBlog(id: string) {
    this.blogService.getBlog(id).subscribe( (resp: RespBlog)  => {
      this.blog = resp.data;
      this.id = this.blog.id;
    } );
  }
  deleteBlog(id: string) {
    this.blogService.deleteBlog(id).subscribe(resp => {
      this.getBlogs()
    })
  }

  saveBlog() {
    if (!this.form.valid) {
      this.form.markAllAsTouched();
      return;
    }

    this.blogService.saveBlog(this.form.value).subscribe(resp => {
      this.getBlogs()
      this.form.reset()
    });
  }

  updateBlog() {
    if (!this.formUpdate.valid) {
      this.formUpdate.markAllAsTouched();
      return;
    }
    this.blogService.updateBlog(this.blog.id, this.formUpdate.value).subscribe( resp => {
      // this.formUpdate.reset();
      this.getBlogs();
    } );
  }
}

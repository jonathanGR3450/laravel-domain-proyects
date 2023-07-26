import { Component } from '@angular/core';
import { BlogService } from '../services/blog.service';
import { Blog } from '../interfaces/blog.interface';
import { Resp } from '../interfaces/resp.interface';

@Component({
  selector: 'app-index',
  templateUrl: './index.component.html',
  styleUrls: ['./index.component.css']
})
export class IndexComponent {

  blogs!: Blog[];

  constructor(private blogService: BlogService) {
    this.getBlogs()
  }

  getBlogs() {
    this.blogService.getBlogs().subscribe((resp: Resp) => {
      this.blogs = resp.data
      console.log(this.blogs);

    });
  }

}

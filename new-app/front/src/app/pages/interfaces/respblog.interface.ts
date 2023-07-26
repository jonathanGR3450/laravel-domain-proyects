import { Blog } from "./blog.interface";

export interface RespBlog {
    status:  string;
    message: string;
    data:    Blog;
}
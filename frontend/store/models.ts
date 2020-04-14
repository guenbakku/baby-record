/* eslint-disable camelcase */
export type DateTime = string
export type Date = string

export type Pagination = {
  page_count: number
  current_page: number
  has_next_page: boolean
  has_prev_page: boolean
  count: number
  limit: number | null
}

export type ApiResponse<T> = {
  success: boolean
  data: T
}

export type IndexResponse<T> = ApiResponse<T> & {
  pagination: Pagination
}
export type ViewResponse<T> = ApiResponse<T>
export type AddResponse = ApiResponse<{ id: string }>
export type EditResponse = ApiResponse<any>
export type DeleteResponse = ApiResponse<any>

export type BaseRecord = {
  id: string | number
  created: DateTime
  modified: DateTime
}

export interface RootState {}

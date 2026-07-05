<!-- Start block -->
@if (session()->has('success'))
<div class="flex justify-center">
    <div id="toast-success" class="absolute top-40 flex items-center w-full max-w-sm p-4 text-body bg-neutral-primary-soft rounded-base shadow-xs border border-default" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 text-fg-success bg-success-soft rounded">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ session()->get('success') }}</div>
        <button type="button" class="ms-auto flex items-center justify-center text-body hover:text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded text-sm h-8 w-8 focus:outline-none" data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
        </button>
    </div>
</div>
@endif

<section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
    <div class="mx-auto max-w-7xl px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                        <label for="keyword" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="search" id="keyword" name="keyword" value="{{ request('keyword') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search posts">
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 md:items-center md:space-x-3">
                    <a href="{{ url('/dashboard/create') }}" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        Add post
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Title</th>
                            <th scope="col" class="px-4 py-3">Category</th>
                            <th scope="col" class="px-4 py-3">Author</th>
                            <th scope="col" class="px-4 py-3">Created</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ url('/dashboard/' . $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                            </th>
                            <td class="px-4 py-3">{{ $post->category->name }}</td>
                            <td class="px-4 py-3">{{ $post->author->name }}</td>
                            <td class="px-4 py-3">{{ $post->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button type="button" @click="open = !open" class="inline-flex items-center rounded-lg p-2 text-sm font-medium text-center text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 rounded-lg bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700">
                                        <a href="{{ url('/dashboard/' . $post->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600" @click="open = false">Show</a>
                                        <a href="{{ route('dashboard.edit', $post->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600" @click="open = false">Edit</a>
                                        <button type="button" data-modal-target="deleteModal-{{ $post->id }}" data-modal-toggle="deleteModal-{{ $post->id }}" @click="setTimeout(() => open = false, 100)" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($posts->hasPages())
            <div class="p-4">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </div>
</section>

@foreach ($posts as $post)
<div id="deleteModal-{{ $post->id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden bg-gray-900/50">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md">
            <div class="relative rounded-lg bg-white p-6 text-center shadow dark:bg-gray-800 sm:p-5">
                <button type="button" class="absolute right-2.5 top-2.5 rounded-lg p-1.5 text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deleteModal-{{ $post->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <svg class="mx-auto mb-3.5 h-11 w-11 text-gray-400 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>

                <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this post?</p>

                <div class="flex items-center justify-center gap-4">
                    <button type="button" data-modal-hide="deleteModal-{{ $post->id }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600">
                        No, cancel
                    </button>

                    <form action="{{ route('dashboard.destroy', $post->slug) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Yes, I'm sure
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End block -->


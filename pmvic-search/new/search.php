<?php
if (empty($_SESSION['loggedin'])) {
  header('Location: index.php');
  die();
}
?>
<section class=" py-1 bg-blueGray-50">
  <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
      <div class="rounded-t bg-white mb-0 px-6 py-6 title">
        <div class="text-center">
          <p class="text-3xl font-semibold italic">LTMS Plate Number Search</p>
        </div>
      </div>
      <div class="w-full p-5">
        <form id="searchForm">
          <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
              </svg>
            </div>
            <input id="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 inputVal" type="search" name="key" class="block p-2 w-full text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 inputVal tracking-wider font-bold" placeholder="Search Plate Number here..." required>
            <input class="block p-2 w-full text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 inputVal tracking-wider font-bold" type="hidden" class="hidden" name="route" value="search">
            <button id="btn_search" type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
          </div>
        </form>
      </div>

      <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
        <div class="flex flex-col hidden" id="searchTbl">
          <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
              <div class="overflow-hidden">

                <table class="min-w-full">
                  <tbody class="bg-white border-b">
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium"><label>License Plate: </label></td>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Make: </label></td>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Color: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Chassis Number: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>MV File Number: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Engine Number: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Series: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Category: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Category Type: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Net Capacity: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Gross Weight: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Year Model: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>


                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Fuel Type: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                    <tr>
                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium "><label>Date of First Registration: </label></td>

                      <td class="text-lg text-gray-900 font-light px-2 py-1 whitespace-nowrap text-center text-bold font-medium ">
                        <div class="relative mt-2 rounded-md shadow-sm">
                          <input type="text" class="block w-full rounded-md border-0 px-2 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 inputVal tracking-wider font-bold" readonly>
                          <div class="absolute inset-y-0 right-0 flex items-center">
                            <button type="submit" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-2 text-gray-500 focus:ring-1 focus:ring-inset focus:ring-gray-600 sm:text-sm text-center bg-gray-200 copy">Copy</button>
                          </div>
                        </div>
                      </td>

                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
  obj.search();
  obj.copyText();
</script>
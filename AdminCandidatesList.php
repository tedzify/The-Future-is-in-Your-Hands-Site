<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <title>Candidate Editor</title>
  </head>

  <body>
    <nav
      class="navbar navbar-light justify-content-center position-relative mb-5"
      style="background-color: rgb(159, 46, 46); color: white"
    >
      <a
        href="AdminCandidatesList"
        class="btn position-absolute start-0 ms-3"
        style="background-color: #f4bd0b; color: white"
      >
        <i class="fas fa-arrow-left"></i>
      </a>
      <span class="fs-3 fw-medium" style="color: white"> Candidate List </span>
    </nav>

    <div class="container">
      <div class="col d-flex mb-3">
        <a
          name="add_candidates"
          id="add_candidates"
          class="col-md-2 btn btn-dark me-3"
          href="AddCandidates"
          role="button"
          >Add New</a
        >
        <select
          name="position_filter"
          id="position_filter"
          class="col form-select"
          onchange="filterCandidates()"
        >
          <option value="all" selected>All Positions</option>
          <option value="mayor">Mayor</option>
          <option value="vice-mayor">Vice Mayor</option>
          <option value="councilor">Councilor</option>
        </select>
      </div>
      <table class="table table-hover text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Full Name</th>
            <th scope="col">Party</th>
            <th scope="col">Age</th>
            <th scope="col">Sex</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>sex</td>
            <td>
              <a href="" class="link-dark"
                ><i class="fa-solid fa-pen-to-square fs-5 me-3"></i
              ></a>
              <a href="" class="link-dark"
                ><i class="fa-solid fa-trash fs-5"></i
              ></a>
            </td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>sex</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry the Bird</td>
            <td>@twitter</td>
            <td>@wat</td>
            <td>sex</td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>

function obj_class() {
  this.login = () => {
    loginForm.onsubmit = async (e) => {
      e.preventDefault();

      let response = await fetch("route.php", {
        method: "POST",
        credentials: "same-origin",
        body: new FormData(loginForm),
      });

      let { message, status } = await response.json();

      if (status == 200) {
        window.location = "./index.php";
      } else {
        this.msgAlert(message, 'warning');
      }
    };
  };

  this.search = () => {
    searchForm.onsubmit = async (e) => {
      e.preventDefault();
      let searchVal = document.querySelector('#search');
      this.isloading(searchVal.value);

      let response = await fetch("route.php", {
        method: "POST",
        credentials: "same-origin",
        body: new FormData(searchForm),
      });

      let { message, status } = await response.json();

      if (status == 200) {
        this.fetchData(message);
        this.isdoneloading();
      } else {
        this.isdoneloading();
        this.msgAlert(message, 'warning');
        const tbl = document.querySelector('#searchTbl');
        tbl.classList.add('hidden');
      }
    }
  };

  this.isloading = (plate) => {
    Swal.fire({
      title: `Searching Data...`,
      html: `<b>${plate}<b>`,
      timer: 1000000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
      }
    })
  }

  this.isdoneloading = () => {
    Swal.close();
  }

  this.fetchData = (data) => {
    let tbl = document.querySelector('#searchTbl'),
    input   = document.querySelectorAll('.inputVal');
    tbl.classList.remove('hidden');

    let result = data['Vehicle_Information'];

    for (let i = 0; i < input.length; i++) {
      switch (i) {
        case 2:
          input[i].value=result.License_Plate;
        break;
        case 3:
          input[i].value=result.Manufacturer;
        break;
        case 4:
          input[i].value=result.Color;
        break;
        case 5:
          input[i].value=result.Chassis;
        break;
        case 6:
          input[i].value=result.MV_File_No;
        break;
        case 7:
          input[i].value=result.Engine;
        break;
        case 8:
          input[i].value=result.Brand;
        break;
        case 9:
          input[i].value=result.Category;
        break;
        case 10:
          input[i].value=result.Category_Type;
        break;
        case 11:
          input[i].value=result.Engine_Capacity;
        break;
        case 12:
          input[i].value=result.Maximum_Total_Weight;
        break;
        case 13:
          input[i].value=result.Model_Year;
        break;
        case 14:
          input[i].value=result.Fuel_Type;
        break;
        case 15:
          input[i].value= this.formatData(result.Date_First_Registration);
        break;
      }
    }
  }

  this.copyText = () => {
    let copyText = document.querySelectorAll('.inputVal');
    let copyBtn = document.querySelectorAll('.copy');
    let obj = new obj_class();
    
      for (let i = 0; i < copyBtn.length; i++) {
        switch (i) {
        case 0:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[2]);
          })
        break;
        case 1:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[3]);
          })
        break;
        case 2:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[4]);
          })
        break;
        case 3:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[5]);
          })
        break;
        case 4:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[6]);
          })
        break;
        case 5:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[7]);
          })
        break;
        case 6:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[8]);
          })
        break;
        case 7:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[9]);
          })
        break;
        case 8:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[10]);
          })
        break;
        case 9:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[11]);
          })
        break;
        case 10:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[12]);
          })
        break;
        case 11:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[13]);
          })
        break;
        case 12:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[14]);
          })
        break;
        case 13:
          copyBtn[i].addEventListener('click', function() {
            obj.copyTextFunction(copyText[15]);
          })
        break;
      }
    }
  }

  this.copyTextFunction = (copyText) => {
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
  }

  this.formatData = (str) => {
    const date = new Date(str);

    const formattedDate = date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
    });

    return formattedDate;
  }

  this.msgAlert = (message, status) => {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    
    Toast.fire({
      icon: status,
      title: message
    })
  }
}
let obj = new obj_class();

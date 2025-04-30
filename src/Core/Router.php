<?php

namespace App\Core;

class Router
{
  // request method 체크
  private function getMethod(): string
  {
    $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

    switch ($method) {
      case "PUT": // put == patch
      case "PATCH":
        $return = "update";
        break;
      case "DELETE":
        $return = "destroy";
        break;
      case "POST":
        $return = "store";
        break;
      default:
        $return = "get";
        break;
    }

    return $return;
  }
  // snake_case -> CamelCase 변경
  private function toStudlyCase(string $str): string
  {
    return str_replace(" ", "", ucwords(str_replace("_", " ", strtolower($str))));
  }

  public function handleRequest(string $path): void
  {
    // 경로 / 기준으로 배열화
    $segments = explode("/", trim($path, "/"));

    // request mehod 확인
    $httpMethod = $this->getMethod();

    // arr[0] === "admin" ? admin : user & 기본 홈페이지
    if (count($segments) > 0 && $segments[0] === "admin") {
      array_shift($segments); // admin 제거
      // admin controller는 Admin{segments[0]}Controller.php 파일명으로 제작
      $controllerName = 'Admin' . $this->toStudlyCase($segments[0] ?? "index") . 'Controller';
      $controllerClass = "App\\Controllers\\Admin\\$controllerName";
      $this->request($segments, $httpMethod, $controllerClass);
    } else {
      $controllerName = $this->toStudlyCase($segments[0] ?? "index") . 'Controller';
      $controllerClass = "App\\Controllers\\User\\$controllerName";
      $this->request($segments, $httpMethod, $controllerClass);
    }
  }

  private function request(
    array $segments,
    string $httpMethod,
    string $controllerClass
  ): void {
    // get은 create 페이지 때문에 method 한번 더 변환(admin에서 사용)
    if ($httpMethod === "get") {
      // 기본 = handle, 상세 페이지는 $segments[1]이 숫자인 경우(id), 생성 페이지는 create
      // 0번째는 lsit(기본), 1번째는 detail || create
      // 메소드 변환
      $method = "handle";
      $param = $segments[1] ?? null;
      if ($param) {
        // number->detail
        if (is_numeric($param)) {
          $method = "info";
        } else {
          // create인 경우
          $method = $param;
        }
      }
    } else {
      // post, patch, delete는 메소드 그대로 전달
      $method = $httpMethod;
    }

    if (class_exists($controllerClass)) {
      $controller = new $controllerClass();
      $controller->$method($param ?? null);
    } else {
      http_response_code(404);
      echo "<h1>404 Not Found</h1>";
      echo "<pre>Looking for: $controllerClass</pre>";
    }
  }
}
